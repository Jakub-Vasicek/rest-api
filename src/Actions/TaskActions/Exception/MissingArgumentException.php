<?php

declare(strict_types=1);

namespace JakVas\Application\Actions\TaskActions\Exception;

class MissingArgumentException extends \Exception
{
    public static function missingArgumentException(string $argument): self
    {
        return new self('Missing argument: ' . $argument);
    }
}