<?php

declare(strict_types=1);

namespace JakVas\Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241219222356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration for tasks table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tasks (id CHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tasks');
    }
}
