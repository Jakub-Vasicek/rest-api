<?php
declare(strict_types=1);

namespace JakVas\Application\Model\Task;

class TaskData
{

    public string $title;
    public ?string $description;
    public TaskStatus $status;

    public static function fromArray(array $data): self
    {
        $taskData = new self();
        $taskData->title = $data['title'] ?? throw new \InvalidArgumentException('Title is required');
        $taskData->description = $data['description'] ?? null;
        $taskData->status = TaskStatus::from($data['status']) ?? throw new \InvalidArgumentException('Status is required');

        return $taskData;
    }

    /**
     * @param TaskData $taskData
     * @param array $data{
     *      title?: string,
     *      description?: string,
     *      status?: string
     * }
     * @return self
     */
    public static function updateFromIncompleteSet(TaskData $taskData, array $data): self
    {
        $taskData->title = $data['title'] ?? $taskData->title;
        $taskData->description = $data['description'] ?? $taskData->description;
        $taskData->status = TaskStatus::from($data['status']) ?? $taskData->status;

        return $taskData;
    }
}