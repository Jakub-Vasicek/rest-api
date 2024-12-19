<?php
declare(strict_types=1);

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return static function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello! I run on php 8.3!');
        return $response;
    });

    $container = $app->getContainer();

    if ($container === null) {
        throw new \RuntimeException('Dependency injection container is missing.');
    }
};