database:
	 docker-compose exec php ./vendor/bin/doctrine orm:schema-tool:update  --force --complete

fixtures:
	docker-compose exec php ./vendor/bin/doctrine dbal:import ./.sql/db_seed.sql

database-update:
	 docker-compose exec php ./vendor/bin/doctrine orm:schema-tool:update  --force --complete
up:
	 cp -r .env.dist .env
	 docker-compose up --build --d
	 docker-compose exec php composer install
	 docker-compose exec php ./vendor/bin/doctrine orm:schema-tool:update  --force --complete
	 docker-compose exec php ./vendor/bin/doctrine dbal:import ./.sql/db_seed.sql

DFS:
	docker-compose exec php php ./bin/console.php algorithms:DFS testCommand B
BFS:
	docker-compose exec php php ./bin/console.php algorithms:DFS testCommand B
test:
	docker-compose exec php ./vendor/bin/phpunit