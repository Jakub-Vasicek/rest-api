<?php

declare(strict_types=1);

namespace JakVas\Application\Actions\TaskActions;

use JakVas\Application\Actions\BaseAction;
use JakVas\Application\Model\Task\TaskData;
use JakVas\Application\Model\Task\TaskRepository;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @OA\Put(
 *     path="/task/{id}",
 *     summary="Update a task",
 *     @OA\Parameter(
 *      name="id",
 *      in="path",
 *      required=true,
 *      description="ID of the task to update",
 *      @OA\Schema(
 *          type="string",
 *          format="uuid"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Task")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Task updated"
 *      )
 * )
 * @OA\PathItem(
 *     path="/task/{id}"
 * )
 */
class UpdateTaskAction extends BaseAction
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
        $taskId = $this->resolveArg('id');
        $task = $this->taskRepository->findByUuid($taskId);

        if ($task === null) {
            $this->response->getBody()->write("Task $taskId not found");
            return $this->response->withStatus(404);
        }

        $requestData = json_decode($this->request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $taskDataNew = TaskData::updateFromIncompleteSet($task->getData(), $requestData);

        $task->updateTask($taskDataNew);
        $this->taskRepository->updateTask($task);

        $response = $this->response->withStatus(200);
        $response->getBody()->write(json_encode($task->jsonSerialize(), JSON_THROW_ON_ERROR));
        return $response;
    }
}