<?php
declare(strict_types=1);

namespace JakVas\Application\Model\Task;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     required={"title", "status"},
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="created_at", type="datetime"),
 *     @OA\Property(property="updated_at", type="datetime")
 * )
 */
#[Entity, Table(name: 'tasks')]
class Task implements \JsonSerializable
{
    #[Id]
    #[Column(name: 'id', type: 'uuid', unique: true, nullable: false)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[Column(name: 'title', type: 'string', length: 255, unique: false, nullable: false)]
    private string $title;

    #[Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description;

    #[Column(name: 'status', type: 'string', length: 255, nullable: false, enumType: TaskStatus::class)]
    private TaskStatus $status;

    #[Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(TaskData $taskData)
    {
        $this->id = Uuid::uuid4();
        $this->title = $taskData->title;
        $this->description = $taskData->description;
        $this->status = $taskData->status;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function updateTask(TaskData $taskData): void
    {
        $this->title = $taskData->title;
        $this->description = $taskData->description;
        $this->status = $taskData->status;
        $this->updatedAt = new DateTime();
    }

    public function getData(): TaskData
    {
        return TaskData::fromArray([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value
        ]);
    }

    /**
     * @return array{
     *     title: string,
     *     description: string,
     *     status: string,
     *     created_at: DateTime,
     *     updated_at: DateTime
     * }
     */
    public function jsonSerialize(): array
    {

        return [
            'id' => $this->id->toString(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}