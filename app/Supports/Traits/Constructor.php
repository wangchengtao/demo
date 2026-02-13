<?php

declare(strict_types=1);

namespace App\Supports\Traits;

use ReflectionClass;

trait Constructor
{
    public function __construct(array $params = [])
    {
        $reflectionClass = new ReflectionClass($this);

        foreach ($params as $key => $value) {
            if ($reflectionClass->hasProperty($key)) {
                $property = $reflectionClass->getProperty($key);
                $property->setValue($this, $value);

                continue;
            }

            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }
}
