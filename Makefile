step=-----------------------
project=randos1000etangs
host=randos1000etangs.dev
sf=app/console
compose=docker-compose -p $(project)

# REQUIREMENT
install-docker:
	@echo "$(step) Installing docker $(step)"
	@sudo apt-get update
	@sudo apt-get install docker.io
	@curl -sSL https://get.docker.com/ubuntu/ | sudo sh
	@source /etc/bash_completion.d/docker.io

install-compose:
	@echo "$(step) Installing docker-compose $(step)"
	@curl -L https://github.com/docker/compose/releases/download/1.1.0/docker-compose-`uname -s`-`uname -m` > /tmp/docker-compose
	@sudo mv /tmp/docker-compose /usr/local/bin/docker-compose
	@chmod +x /usr/local/bin/docker-compose

requirements: install-docker install-compose

# ASSETS
assets:
	@echo "$(step) Installation assets dev $(step)"
	@$(compose) run --rm web $(sf) assets:install --symlink

# DATABASE
fixtures:
	@echo "$(step) Installing fixtures $(step)"
	@$(compose) run --rm web \
		$(sf) doctrine:mongodb:fixtures:load

# VENDORS
vendor-install: composer-install npm-install bower-install

composer-install:
	@$(compose) run --rm composer install -n --prefer-dist --ignore-platform-reqs

composer-update:
	@$(compose) run --rm composer update -n --prefer-dist --ignore-platform-reqs

bower-install:
	@$(compose) run --rm builder bower --allow-root install

npm-install:
	@$(compose) run --rm builder npm install --loglevel info


# TESTS
phpunit:
	@sudo fig run --rm web bin/phpunit -c app/


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

bash:
	@echo "$(step) Bash $(project) $(step)"
	@$(compose) run --rm web bash
