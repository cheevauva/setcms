COMPOSE_DEV=./docker/dev/docker-compose.yaml
COMPOSE_NAME=setcms4
COMPOSE_ENV=./.env

up:;docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) up --build -d
down:;docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) down
php:;docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) exec php bash
mysql:;docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) exec mysql mysql -uroot -proot
logs:;docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) logs -f
ps:;docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) ps
stan:; docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) exec -T php ../vendor/bin/phpstan analyse $(ARGS) -c ../phpstan.neon --memory-limit=2000M --no-progress
stan_baseline:; docker compose -p $(COMPOSE_NAME) -f $(COMPOSE_DEV) --env-file $(COMPOSE_ENV) exec -T php ../vendor/bin/phpstan analyse -c ../phpstan.neon --generate-baseline --memory-limit=512M -vv