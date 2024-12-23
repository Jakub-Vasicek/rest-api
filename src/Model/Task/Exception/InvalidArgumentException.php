<?php

declare(strict_types=1);

namespace JakVas\Application\Model\Task\Exception;

class InvalidArgumentException extends \Exception
{
    public static function missingTitleException(): self
    {
        return new self('Title is required to create a task.');
    }

    public static function missingStatusException(): self
    {
        return new self('Status is required to create a task.');
    }
}