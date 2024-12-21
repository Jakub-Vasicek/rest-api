<?php
declare(strict_types=1);

namespace JakVas\Application\Model\Task;

use Doctrine\ORM\EntityManager;

readonly class TaskRepository
{

    public function __construct(private EntityManager $em)
    {
    }

    public function create(Task $task)
    {
        $this->em->persist($task);
        $this->em->flush();
    }

    public function updateTask(Task $task): Task
    {
        $this->em->flush();

        return $task;
    }

    /**
     * @return array<Task>
     */
    public function listTasks(): array
    {
        return $this->em->getRepository(Task::class)->findAll();
    }

    public function findByUuid(string $uuid): ?Task
    {
        return $this->em->getRepository(Task::class)->findOneBy([
            'id' => $uuid,
        ]);
    }

    /**
     * @return array<Task>
     */
    public function listTasksByStatus(TaskStatus $status): array
    {
        return $this->em->getRepository(Task::class)->findBy([
            'status' => $status,
        ]);
    }
}
