COMPOSE_FILE := docker-compose.yml

DOCKER_COMPOSE := docker compose -f $(COMPOSE_FILE)

.PHONY: build up down restart logs bash exec help clean

help:
	@echo "Available commands:"
	@echo "  make build             - Builds all Docker images defined in the compose file."
	@echo "  make up                - Starts all containers in detached mode."
	@echo "  make down              - Stops and removes all containers, networks, and default volumes."
	@echo "  make restart           - Restarts all services."
	@echo "  make logs              - Displays logs for all services in real-time."
	@echo "  make bash SERVICE=<name> - Connects to a specific service container via bash (e.g., make bash SERVICE=web)."
	@echo "  make exec SERVICE=<name> CMD=\"...\" - Executes an arbitrary command inside a specific service container (e.g., make exec SERVICE=php CMD=\"composer install\")."
	@echo "  make clean             - Stops and removes containers, networks, volumes, and dangling images."

build:
	$(DOCKER_COMPOSE) build --no-cache

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) restart

logs:
	$(DOCKER_COMPOSE) logs -f

bash:
	@if [ -z "$(SERVICE)" ]; then \
		echo "Error: SERVICE is required. Usage: make bash SERVICE=your_service_name"; \
		exit 1; \
	fi
	$(DOCKER_COMPOSE) exec -it $(SERVICE) bash

exec:
	@if [ -z "$(SERVICE)" ]; then \
		echo "Error: SERVICE is required. Usage: make exec SERVICE=your_service_name CMD=\"...\""; \
		exit 1; \
	fi
	@if [ -z "$(CMD)" ]; then \
		echo "Error: CMD is required. Usage: make exec SERVICE=your_service_name CMD=\"...\""; \
		exit 1; \
	fi
	$(DOCKER_COMPOSE) exec $(SERVICE) $(CMD)

clean: down
	@echo "Removing dangling Docker images..."
	docker image prune -f

cs-fix:
	$(DOCKER_COMPOSE) exec php composer code:style:fix