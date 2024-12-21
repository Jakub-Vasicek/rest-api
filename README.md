# REST API simple app

## Installation 

1. `docker compose up`
2. Enter the container by `docker compose exec php bash`
3. `composer install`
4. copy `.env.development.dist` to `.env`
5. create `DEVELOPMENT` file in the root directory

## Swagger

1. generate swagger file by `composer app-generate-swagger`