<?php

namespace App\Traits;

use ReflectionEnum;

trait EnumFromName
{
    public static function tryFromName(string $name): ?static
    {
        $reflection = new ReflectionEnum(static::class);

        return $reflection->hasCase($name)
            ? $reflection->getCase($name)->getValue()
            : null;
    }
}
