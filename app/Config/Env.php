<?php

declare(strict_types=1);

namespace App\Config;

use OutOfBoundsException;
use RangeException;

final class Env
{
    public static function get(string $name): null|string
    {
        $value = getenv($name, true);
        if ($value === false) {
            return null;
        }
        return $value;
    }

    public static function str(string $name, string $default = null): string
    {
        $value = self::get($name);
        if ($value === null) {
            if ($default === null) {
                throw new OutOfBoundsException("Env var < $name > is not set");
            }
            return $default;
        }
        return $value;
    }

    public static function int(string $name, int $default = null): int
    {
        $value = self::get($name);
        if ($value === null) {
            if ($default === null) {
                throw new OutOfBoundsException("Env var < $name > is not set");
            }
            return $default;
        }
        if (is_numeric($value)) {
            return (int)$value;
        }
        throw new RangeException("Env var < $name > cannot be converted to int");
    }
}
