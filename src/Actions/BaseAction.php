<?php

declare(strict_types=1);

namespace JakVas\Application\Actions;

use JakVas\Application\Actions\TaskActions\Exception\MissingArgumentException;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

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
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        return $this->action();
    }

    /**
     * @throws MissingArgumentException
     */
    protected function resolveArg(string $name): string
    {
        if (!isset($this->args[$name])) {
            throw MissingArgumentException::missingArgumentException($name);
        }

        return $this->args[$name];
    }
}