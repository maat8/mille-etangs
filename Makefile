step=-----------------------
project=randos1000etangs
host=randos1000etangs.dev
sf=app/console
compose=sudo docker-compose -p $(project)


# HELP MENU
all: help
help:
	@echo ""
	@echo "-- Help Menu"
	@echo ""
	@echo "   1.  make requirements         - Install requirements"
	@echo "   2.  make install              - Install $(project)"
	@echo "   3.  make update               - Update $(project)"
	@echo "   4.  make start                - Start $(project)"
	@echo "   5.  make stop                 - Stop $(project)"
	@echo "   6.  make restart              - Stop and start $(project)"
	@echo "   7.  make state                - Etat $(project)"
	@echo "   8.  make cc                   - Cache clear"
	@echo "   9.  make tests                - Launch tests"
	@echo "   10. make cs                   - Launch check style coke"
	@echo "   11. make assets               - Install assets"
	@echo "   18. make composer-install     - Install vendor"
	@echo "   19. make composer-update      - Update vendor"
	@echo "   20. make bash                 - Launch bash $(project)"
	@echo ""


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


# CACHE
cache-clear:
	@echo "$(step) Clear cache dev $(step)"
	@$(compose) run --rm web $(sf) cache:clear --no-warmup --env=dev
	#@$(compose) run --rm web $(sf) apc:clear

cache-clear-test:
	@echo "$(step) Clear cache test $(step)"
	@$(compose) run --rm web $(sf) cache:clear --no-warmup --env=test
	#@$(compose) run --rm web $(sf) apc:clear --env=test

cc: cache-clear
cctest: cache-clear-test


# Assetic
assets:
	@echo "$(step) Installation assets dev $(step)"
	@$(compose) run --rm web $(sf) assets:install --symlink

assets-test:
	@echo "$(step) Installation assets test $(step)"
	@$(compose) run --rm web $(sf) assets:install --symlink
	@$(compose) run --rm web $(sf) assetic:dump --env=prod


# DATABASE
fixtures:
	@echo "$(step) Installing fixtures $(step)"
	@$(compose) run --rm web \
		$(sf) doctrine:mongodb:fixtures:load


# VENDOR
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

tests: cctest cs phpunit


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

install: remove build start host-dev composer-install  fixtures assets cache-clear install-pre-commit

install-test: remove build up composer-install assets-test cache-clear-test

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
