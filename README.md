# ERP

SAAS based ERP.

## How to run

* Install dependencies: `composer install`
* Start containers: `cd erp/docker`, `docker-compose up -d`
* Run migrations: `php artisan migrate:install`, `php artisan migrate`
* Command to start up docker with cache `docker-compose down && docker-compose build && docker-compose up -d && docker logs webserver`
* Command to start up docker without cache `docker-compose down && docker-compose build --no-cache && docker-compose up -d && docker logs webserver`

## Start up

1. Database used is PostgresSQL
2. Uses CircleCI as the default CI platform
3. Application is available on either https://localhost or https://saas-erp.local [https redirection automatically takes place.]

## Docker compose cheatsheet

**Note:** you need to cd first to where your docker-compose.yml file lives.

* Start containers in the background: `docker-compose up -d`
* Start containers on the foreground: `docker-compose up`. You will see a stream of logs for every container running.
* Stop containers: `docker-compose stop`
* Kill containers: `docker-compose kill`
* View container logs: `docker-compose logs`
* Execute command inside of container: `docker-compose exec SERVICE_NAME COMMAND` where `COMMAND` is whatever you want to run. Examples:
* Shell into the PHP container: `docker exec -it app /bin/bash`
* Shell into the Webserver container: `docker exec -it webserver /bin/sh`
* Open a mysql shell, `docker-compose exec mysql mysql -uroot -pCHOSEN_ROOT_PASSWORD`

## Swagger cheatsheet

* Generate Swagger documentation `php artisan swagger-lume:publish`

## Services exposed outside your environment

Service | Address outside containers

Webserver | [localhost:8080](http://localhost:8080)

Mailhog web interface | [localhost:8081](http://localhost:8081)

MySQL |**host:** `localhost`; **port:** `8082`

Graylog | localhost:9000

Adminer | localhost:8089/adminer

Swagger | localhost:8080/api/documentation
