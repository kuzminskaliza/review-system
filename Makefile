# Збудувати контейнери
up-build:
	docker compose up -d --build

#Запустити контейнери
up:
	docker compose up -d

# Зупинка всіх контейнерів
down:
	docker compose down

# Вхід у контейнер PHP CLI
cli:
	docker exec -it php-cli-review bash

# Вхід у контейнер PHP-FPM
fpm:
	docker exec -it php-fpm-review bash

# Вхід у контейнер Postgres
db:
	docker exec -it postgres-review psql -U admin -d review_system

# Ініціалізація проєкту (в режимі dev)
init:
	docker exec -it php-cli-review php init --env=Development --overwrite=All

# Виконати міграції
migrate:
	docker exec -it php-cli-review php yii migrate --interactive=0

# Старт усього: init + build + migrate
start: init up-build migrate