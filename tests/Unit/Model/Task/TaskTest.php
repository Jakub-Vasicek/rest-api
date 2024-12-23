<?php
declare(strict_types=1);

namespace Model\Task;

use JakVas\Application\Model\Task\Exception\InvalidArgumentException;
use JakVas\Application\Model\Task\Task;
use JakVas\Application\Model\Task\TaskData;
use JakVas\Application\Model\Task\TaskStatus;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testIncompleteDatasetThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $task = new Task(TaskData::fromArray([
            'description' => 'Description.',
            'status' => 'todo'
        ]));

        $this->expectException(InvalidArgumentException::class);
        $task = new Task(TaskData::fromArray([
            'title' => 'Initial Task',
            'description' => 'Initial description.',
        ]));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testUpdateTaskFromFullDataset(): void
    {
        $task = new Task(TaskData::fromArray([
            'title' => 'Initial Task',
            'description' => 'Initial description.',
            'status' => 'todo'
        ]));
        $initialUpdatedAt = $task->getUpdatedAt();
        sleep(1);

        $task->updateTask(TaskData::fromArray([
            'title' => 'Updated Task',
            'description' => 'Updated description.',
            'status' => 'done'
        ]));
        $newUpdatedAt = $task->getUpdatedAt();
        $taskData = $task->getData();

        $this->assertEquals('Updated Task', $taskData->title);
        $this->assertEquals('Updated description.', $taskData->description);
        $this->assertEquals(TaskStatus::DONE, $taskData->status);
        $this->assertGreaterThan($initialUpdatedAt->getTimestamp(), $newUpdatedAt->getTimestamp());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testUpdateTaskDescriptionOnly(): void
    {
        $task = new Task(TaskData::fromArray([
            'title' => 'Initial Task',
            'description' => 'Initial description.',
            'status' => 'todo'
        ]));
        $initialUpdatedAt = $task->getUpdatedAt();
        sleep(1);

        $task->updateFromIncompleteSet(['description' => 'Updated description.']);
        $newUpdatedAt = $task->getUpdatedAt();
        $taskData = $task->getData();

        $this->assertEquals('Initial Task', $taskData->title);
        $this->assertEquals('Updated description.', $taskData->description);
        $this->assertEquals(TaskStatus::TODO, $taskData->status);
        $this->assertGreaterThan($initialUpdatedAt->getTimestamp(), $newUpdatedAt->getTimestamp());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testUpdateTaskStatusOnly(): void
    {
        $task = new Task(TaskData::fromArray([
            'title' => 'Initial Task',
            'description' => 'Initial description.',
            'status' => 'todo'
        ]));
        $initialUpdatedAt = $task->getUpdatedAt();
        sleep(1);

        $task->updateFromIncompleteSet(['status' => 'done']);
        $newUpdatedAt = $task->getUpdatedAt();
        $taskData = $task->getData();

        $this->assertEquals('Initial Task', $taskData->title);
        $this->assertEquals('Initial description.', $taskData->description);
        $this->assertEquals(TaskStatus::DONE, $taskData->status);
        $this->assertGreaterThan($initialUpdatedAt->getTimestamp(), $newUpdatedAt->getTimestamp());
    }

    /**
     * @throws \JsonException
     * @throws InvalidArgumentException
     */
    public function testJsonSerialize(): void
    {
        $task = new Task(TaskData::fromArray([
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'todo'
        ]));
        $id = $task->getId();
        $updatedAt = $task->getUpdatedAt();
        $createdAt = $task->getCreatedAt();

        $expectedJson = json_encode(
            [
            'id' => $id->toString(), //not actually tested
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'todo',
            'created_at' => $createdAt->format('Y-m-d H:i:s'), //not actually tested
            'updated_at' => $updatedAt->format('Y-m-d H:i:s'), //not actually tested
            ],
            JSON_THROW_ON_ERROR
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($task, JSON_THROW_ON_ERROR));
    }
}
