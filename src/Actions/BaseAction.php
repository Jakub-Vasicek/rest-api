<?php

declare(strict_types=1);

namespace JakVas\Application\Actions;

use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="REST API",
 *     description="A simple REST API for demonstration purposes."
 * )
 * @OA\Server(
 *       url="http://localhost:8000",
 *       description="Localhost server"
 *   )
 */
abstract class BaseAction
{
    protected Request $request;

    protected Response $response;

    /** @var string[] */
    protected array $args;

    abstract protected function action(): Response;

    /**
     * @param string[] $args
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(ServerRequestInterface $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        return $this->action();
    }

    protected function resolveArg(string $name): string
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }
}