<?php
declare(strict_types=1);

namespace JakVas\Application\Actions\TaskActions;

use JakVas\Application\Actions\BaseAction;
use JakVas\Application\Model\Task\TaskRepository;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @OA\Get(
 *     path="/task",
 *     summary="List all tasks",
 *     @OA\Response(
 *          response="200",
 *          description="List of tasks",
 *          @OA\JsonContent(ref="#/components/schemas/Task")
 *     )
 * )
 * @OA\PathItem(
 *     path="/task"
 * )
 */
class ListTaskAction extends BaseAction
{
    public function __construct(
        private readonly TaskRepository $taskRepository
    ) {
    }

    /**
     * @throws \JsonException
     */
    protected function action(): Response
    {
        $tasks = array_map(static fn($task) => $task->jsonSerialize(), $this->taskRepository->listTasks());

        $response = $this->response->withStatus(200);
        $response->getBody()->write(json_encode($tasks, JSON_THROW_ON_ERROR));
        return $response;
    }
}