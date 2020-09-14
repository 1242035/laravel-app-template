up:
	docker-compose up -d
build:
	docker-compose build --no-cache --force-rm
create-project:
	@make build
	@make up
	docker-compose exec app composer create-project --prefer-dist laravel/laravel .
	docker-compose exec app chmod -R 777 storage bootstrap/cache
install-recommend-packages:
	docker-compose exec app composer require doctrine/dbal
	docker-compose exec app composer require --dev barryvdh/laravel-ide-helper
	docker-compose exec app composer require --dev beyondcode/laravel-dump-server
	docker-compose exec app composer require --dev barryvdh/laravel-debugbar
	docker-compose exec app composer require --dev roave/security-advisories:dev-master
	docker-compose exec app php artisan vendor:publish --provider="BeyondCode\DumpServer\DumpServerServiceProvider"
	docker-compose exec app php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
init:
	docker-compose up -d --build
	docker-compose exec app composer install --ignore-platform-reqs
	docker-compose exec app cp .env.example .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan storage:link
	docker-compose exec app php artisan migrate:fresh --seed
	docker-compose exec app php artisan passport:install
	docker-compose exec app yarn
	docker-compose exec app yarn dev
update:
	docker-compose exec app composer update --ignore-platform-reqs
	docker-compose exec app yarn
	docker-compose exec app yarn dev
	docker-compose exec app php artisan config:cache
remake:
	@make destroy
	@make init
stop:
	docker-compose stop
start:
	docker-compose start
down:
	docker-compose down
restart:
	@make down
	@make up
destroy:
	docker-compose down --rmi all --volumes
destroy-volumes:
	docker-compose down --volumes
ps:
	docker-compose ps
logs:
	docker-compose logs
logs-watch:
	docker-compose logs --follow
web:
	docker-compose exec nginx ash
app:
	docker-compose exec app bash
migrate:
	docker-compose exec app php artisan migrate
fresh:
	docker-compose exec app php artisan migrate:fresh --seed
	docker-compose exec app php artisan passport:install
refresh:
	docker-compose exec app php artisan migrate:refresh --seed
	docker-compose exec app php artisan passport:install
seed:
	docker-compose exec app php artisan db:seed
rollback-test:
	docker-compose exec app php artisan migrate:fresh
	docker-compose exec app php artisan migrate:refresh
tinker:
	docker-compose exec app php artisan tinker
test:
	docker-compose exec app php artisan test
optimize:
	docker-compose exec app php artisan optimize
optimize-clear:
	docker-compose exec app php artisan optimize:clear
cache:
	docker-compose exec app composer dump-autoload -o
	docker-compose exec app php artisan config:cache
	# @make optimize
cache-clear:
	@make optimize-clear
npm:
	@make npm-install
npm-install:
	docker-compose exec app npm install
npm-dev:
	docker-compose exec app npm run dev
npm-watch:
	docker-compose exec app npm run watch
npm-watch-poll:
	docker-compose exec app npm run watch-poll
npm-hot:
	docker-compose exec app npm run hot
yarn:
	docker-compose exec app yarn
yarn-install:
	@make yarn
yarn-dev:
	docker-compose exec app yarn dev
yarn-watch:
	docker-compose exec app yarn watch
yarn-watch-poll:
	docker-compose exec app yarn watch-poll
yarn-hot:
	docker-compose exec app yarn hot
db:
	docker-compose exec mysql bash
sql:
	docker-compose exec mysql bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
redis:
	docker-compose exec redis redis-cli
ide-helper:
	docker-compose exec app php artisan clear-compiled
	docker-compose exec app php artisan ide-helper:generate
	docker-compose exec app php artisan ide-helper:meta
	docker-compose exec app php artisan ide-helper:models --nowrite
