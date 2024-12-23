<?php
declare(strict_types=1);

namespace JakVas\Application\Actions\TaskActions;

use JakVas\Application\Actions\BaseAction;
use JakVas\Application\Model\Task\TaskRepository;
use JakVas\Application\Model\Task\TaskStatus;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @OA\Get(
 *     path="/api/v1/task/by-status/{status}",
 *     summary="List all tasks",
 *     @OA\Parameter(
 *          name="status",
 *          in="path",
 *          required=true,
 *          description="Status of the task",
 *          @OA\Schema(type="string", enum={"todo", "done", "in_progress"})
 *    ),
 *     @OA\Response(
 *          response="200",
 *          description="List of tasks filtered by status",
 *          @OA\JsonContent(ref="#/components/schemas/Task")
 *     ),
 *     @OA\Response(
 *          response="400",
 *          description="Invalid input"
 *     )
 * )
 * @OA\PathItem(
 *     path="/api/v1/task/by-status/{status}"
 * )
 */
class ListTaskByStatusAction extends BaseAction
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
        try {
            $status = TaskStatus::from($this->resolveArg('status'));
        } catch (\ValueError) {
            $this->response->getBody()->write("Invalid status: " . $this->resolveArg('status'));
            return $this->response->withStatus(400);
        }

        $tasksSerialized = array_map(
            static fn($task) => $task->jsonSerialize(),
            $this->taskRepository->listTasksByStatus($status)
        );

        $response = $this->response->withStatus(200);
        $response->getBody()->write(json_encode($tasksSerialized, JSON_THROW_ON_ERROR));
        return $response;
    }
}