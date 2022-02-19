COMPOSE_DEV=./docker/dev/docker-compose.yaml

ps:;docker-compose -f $(COMPOSE_DEV) ps
build:;docker-compose -f $(COMPOSE_DEV) build
up:;docker-compose -f $(COMPOSE_DEV) up --build -d
down:;docker-compose -f $(COMPOSE_DEV) down
logs:;docker-compose -f $(COMPOSE_DEV) logs
php:; docker-compose -f $(COMPOSE_DEV) exec php bash
nginx:; docker-compose -f $(COMPOSE_DEV) exec nginx bash