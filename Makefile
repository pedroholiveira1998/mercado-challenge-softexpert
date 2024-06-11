# Variables
COMPOSE = docker compose
BACKEND_SERVICE = backend
BACKEND_DIR = /var/www/html

# Commands
up:
	$(COMPOSE) up

down:
	$(COMPOSE) down

restart:
	$(COMPOSE) restart

logs:
	$(COMPOSE) logs -f

ps:
	$(COMPOSE) ps

build:
	$(COMPOSE) build

backend-shell:
	$(COMPOSE) exec backend /bin/bash

migrate:
	$(COMPOSE) exec backend php /var/www/html/migrate/migrate.php

composer:
	$(COMPOSE) exec $(BACKEND_SERVICE) composer install --working-dir=$(BACKEND_DIR)

database-shell:
	$(COMPOSE) exec database /bin/bash