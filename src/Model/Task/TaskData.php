<?php
declare(strict_types=1);

namespace JakVas\Application\Model\Task;

use JakVas\Application\Model\Task\Exception\InvalidArgumentException;

class TaskData
{

    public string $title;
    public ?string $description;
    public TaskStatus $status;

    /**
     * @param array $data {
     *      title: string,
     *      description?: string,
     *      status: string
     * }
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        $taskData = new self();
        $taskData->title = $data['title'] ?? throw InvalidArgumentException::missingTitleException();
        $taskData->description = $data['description'] ?? null;
        $taskData->status =
            TaskStatus::from($data['status'])
            ?? throw InvalidArgumentException::missingStatusException();

        return $taskData;
    }
}