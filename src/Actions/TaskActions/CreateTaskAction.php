<?php
declare(strict_types=1);

namespace JakVas\Application\Actions\TaskActions;

use JakVas\Application\Actions\BaseAction;
use JakVas\Application\Model\Task\Task;
use JakVas\Application\Model\Task\TaskData;
use JakVas\Application\Model\Task\TaskRepository;
use JakVas\Application\Model\Task\TaskStatus;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @OA\Post(
 *     path="/task",
 *     summary="Create a new task",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/Task")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Task created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *    )
 * )
 * @OA\PathItem(
 *     path="/task"
 * )
 */
class CreateTaskAction extends BaseAction
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
        $requestData = json_decode($this->request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $validationResponse = $this->validateData($requestData);

        if ($validationResponse !== null) {
            return $validationResponse;
        }

        $task = new Task(TaskData::fromArray($requestData));
        $this->taskRepository->create($task);

        $response = $this->response->withStatus(201);
        $response->getBody()->write(json_encode($task->jsonSerialize(), JSON_THROW_ON_ERROR));
        return $response;
    }

    /**
     * @throws \JsonException
     */
    private function validateData(array $data): ?Response
    {
        if (!isset($data['title'])) {
            $response = $this->response->withStatus(400);
            $response->getBody()->write(json_encode(['error' => 'Title is required'], JSON_THROW_ON_ERROR));
            return $response;
        }

        if (!isset($data['status'])) {
            $response = $this->response->withStatus(400);
            $response->getBody()->write(json_encode(['error' => 'Status is required'], JSON_THROW_ON_ERROR));
            return $response;
        }

        try {
            $status = TaskStatus::from($data['status']);
        } catch (\ValueError) {
            $response = $this->response->withStatus(400);
            $response->getBody()->write(
                json_encode(
                    ['error' => 'Invalid status: ' . $data['status']],
                    JSON_THROW_ON_ERROR
                )
            );
            return $response;
        }

        return null;
    }
}