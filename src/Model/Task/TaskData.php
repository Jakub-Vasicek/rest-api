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
}