<?php

declare(strict_types=1);

namespace JakVas\Application\Components\Helpers;

class EnvironmentHelper
{
    public static function isDevelopmentEnvironment(): bool
    {

        return file_exists(__DIR__ . '/../../DEVELOPMENT');
    }

    public static function isProductionEnvironment(): bool
    {
        return file_exists(__DIR__ . '/../../PRODUCTION');
    }

}