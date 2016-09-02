# ================================================================================
# NON ROOT USER MANAGEMENT
# ================================================================================

ifeq "$(shell whoami )" "root"
	CONTAINER_USERNAME = root
	CONTAINER_GROUPNAME = root
	HOMEDIR = /root
	CREATE_USER_COMMAND =
else
	CONTAINER_USERNAME = dummy
	CONTAINER_GROUPNAME = dummy
	HOMEDIR = /home/$(CONTAINER_USERNAME)
	GROUP_ID = $(shell id -g)
	USER_ID = $(shell id -u)
	CREATE_USER_COMMAND = \
		groupadd -f -g $(GROUP_ID) $(CONTAINER_GROUPNAME) && \
		useradd -u $(USER_ID) -g $(CONTAINER_GROUPNAME) $(CONTAINER_USERNAME) && \
		mkdir -p $(HOMEDIR) &&
endif

AUTHORIZE_HOME_DIR_COMMAND = chown -R $(CONTAINER_USERNAME):$(CONTAINER_GROUPNAME) $(HOMEDIR) &&
EXECUTE_AS = sudo -E -u $(CONTAINER_USERNAME) HOME=$(HOMEDIR)

ADD_SSH_ACCESS_COMMAND = \
  mkdir -p $(HOMEDIR)/.ssh && \
  test -e /var/tmp/id && cp /var/tmp/id $(HOMEDIR)/.ssh/id_rsa ; \
  test -e /var/tmp/known_hosts && cp /var/tmp/known_hosts $(HOMEDIR)/.ssh/known_hosts ; \
  test -e $(HOMEDIR)/.ssh/id_rsa && chmod 600 $(HOMEDIR)/.ssh/id_rsa ; \
  setfacl -R -m u:$(CONTAINER_USERNAME):rwx /var/www > /dev/null 2> /dev/null || true ; \
  setfacl -dR -m u:$(CONTAINER_USERNAME):rwx /var/www > /dev/null 2> /dev/null || true ;

USER_CMD=$(CREATE_USER_COMMAND) $(ADD_SSH_ACCESS_COMMAND) $(AUTHORIZE_HOME_DIR_COMMAND) $(EXECUTE_AS)

step=-----------------------
project=randos1000etangs
host=randos1000etangs.dev
sf=app/console
compose=docker-compose -p $(project)
WEB_DOCKER_CMD=$(compose) run --rm web bash -ci

# COMMON
cache-clear:
	@$(WEB_DOCKER_CMD) '$(sf) cache:clear'
	@$(WEB_DOCKER_CMD) '$(sf) cache:warmup'

cc: cache-clear

# ASSETS
assets:
	@echo "$(step) Installation assets dev $(step)"
	@$(WEB_DOCKER_CMD) '$(sf) assets:install --symlink'

# DATABASE
fixtures:
	@echo "$(step) Installing fixtures $(step)"
	@$(compose) run --rm web \
		$(sf) doctrine:mongodb:fixtures:load -n

# VENDORS
bash:
	@$(compose) run --rm web bash

vendor-install: composer-install npm-install bower-install

composer-install:
	@$(compose) run --rm composer bash -ci '\
		$(USER_CMD) composer install $(composer_options) --ignore-platform-reqs --no-interaction --prefer-dist $(COMMAND_ARGS)'

composer-update:
	@$(compose) run --rm composer bash -ci '\
		$(USER_CMD) composer update --ignore-platform-reqs --no-interaction --prefer-dist $(COMMAND_ARGS)'

bower-install:
	@$(compose) run --rm builder bower --allow-root install

npm-install:
	@$(compose) run --rm builder npm install --loglevel info

# TESTS
phpunit:
	@$(compose) run --rm web php app/console cache:clear --env=test
	@$(compose) run --rm web bin/phpunit -c app

tests: fixtures phpunit

# HOSTS
host-dev:
	@echo "$(step) Installation hosts $(host) $(step)"
	@sudo chmod +x bin/hosts
	@sudo bin/hosts $(project)_web_1 $(host)
	@sudo bin/hosts $(project)_db_1 db.$(host)


# MANAGE
build: remove
	@echo "$(step) Building images docker $(step)"
	@$(compose) build

install: remove build start host-dev composer-install fixtures assets

update: install

up:
	@echo "$(step) Starting $(project) $(step)"
	@$(compose) up -d web db

start: up host-dev

stop:
	@echo "$(step) Stopping $(project) $(step)"
	@$(compose) stop

restart: stop start

state:
	@echo "$(step) Etat $(project) $(step)"
	@$(compose) ps

remove: stop
	@echo "$(step) Remove $(project) $(step)"
	@$(compose) rm --force
