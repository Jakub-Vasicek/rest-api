<?php
declare(strict_types=1);

use JakVas\Application\Actions\TaskActions\CreateTaskAction;
use JakVas\Application\Actions\TaskActions\ListTaskAction;
use JakVas\Application\Actions\TaskActions\UpdateTaskAction;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return static function (App $app) {
    //Often used variables in regular expressions formats
    $uuid = '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}';

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello! I run on php 8.3!');
        return $response;
    });

    $container = $app->getContainer();

    if ($container === null) {
        throw new \RuntimeException('Dependency injection container is missing.');
    }

    $app->group('/task', function (Group $group) use ($uuid) {
        $group->post('[/]', CreateTaskAction::class);
        $group->get('[/]', ListTaskAction::class);
        $group->put("/{id:{$uuid}}", UpdateTaskAction::class);
    });
};
