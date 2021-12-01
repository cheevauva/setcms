COMPOSE_DEV=./docker/docker-compose.yaml

up:
	docker-compose -f $(COMPOSE_DEV) up --build -d

down:
	docker-compose -f $(COMPOSE_DEV) down

php:
	docker-compose -f $(COMPOSE_DEV) exec php bash
