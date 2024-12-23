# REST API simple app

## Installation 

1. `docker compose up`
2. copy environment params file `cp .env.development.dist .env` (password is `app_password`, don't tell anyone!)
3. create environment definition file `touch DEVELOPMENT`
4. Enter the container from terminal by `docker compose exec app bash`
5. `composer install`
6. execute migrations by `./vendor/bin/doctrine-migrations migrate`

## Swagger

1. generate swagger file by `composer app-generate-swagger`

## Testing the endpoints 

- through some swagger interface (doesn't work in PHPStorm)
- good old curl:
  - `curl -X GET 'http://localhost:8000/api/v1/task' -H  'accept: application/json'` 
  - `curl -X GET 'http://localhost:8000/api/v1/task/by-status/{status}' -H  'accept: application/json'`
  - `curl -X POST 'http://localhost:8000/api/v1/task' -H 'accept: */*' -H 'Content-Type: application/json' -d '{"title":"string","status":"todo|in_progress|done","description":"string or null"}'`
  - `curl -X PUT 'http://localhost:8000/api/v1/task/{id}' -H 'accept: */*' -H 'Content-Type: application/json' -d '{"title": "string","status": "todo|in_progress|done","description": "string or null"}'`


## Running tests and PHPStan

1. `composer app-test-unit` - runs tests
2. `composer app-phpstan` - runs PHPStan
