# Variables
COMPOSE = docker compose

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

database-shell:
	$(COMPOSE) exec database /bin/bash