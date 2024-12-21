# REST API simple app

## Installation 

1. `docker compose up`
2. Enter the container from terminal by `docker compose exec app bash`
3. `composer install`
4. copy environment params file `cp .env.development.dist .env`
5. create environment definition file `touch DEVELOPMENT`
6. execute migrations by `./vendor/bin/doctrine-migrations migrate`

## Swagger

1. generate swagger file by `composer app-generate-swagger`