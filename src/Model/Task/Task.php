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
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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

    #[Column(name: 'status', type: 'string', length: 255, nullable: false)]
    private string $status;

    #[Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(string $title, string $status, ?string $description)
    {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->id = Uuid::uuid4();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}