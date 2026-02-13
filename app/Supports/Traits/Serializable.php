<?php

declare(strict_types=1);

namespace App\Supports\Traits;

use App\Supports\Attributes\JsonIgnore;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;

trait Serializable
{
    #[JsonIgnore]
    protected bool $toSnake = false;

    public function toSnake(): static
    {
        $this->toSnake = true;
        return $this;
    }

    public function toArray(): array
    {
        $result = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            if ($property->getAttributes(JsonIgnore::class)) {
                continue;
            }

            if (! $property->isInitialized($this)) {
                continue;
            }

            $propertyName = $this->toSnake ? Str::snake($property->getName()) : $property->getName();
            $propertyValue = $property->getValue($this);

            if (is_null($propertyValue)) {
                continue;
            }

            if (is_array($propertyValue)) {
                $result[$propertyName] = $this->map($propertyValue);
            } elseif ($propertyValue instanceof Arrayable) {
                $result[$propertyName] = $propertyValue->toArray();
            } elseif ($property->getType()->isBuiltin()) {
                $result[$propertyName] = $propertyValue;
            } else {
                throw new InvalidArgumentException('序列化对象属性 (' . $property->getName() . ') 类型必须是内置类型或实现 Arrayable 接口');
            }
        }

        return $result;
    }

    protected function map(array $properties): array
    {
        return array_map(fn ($item) => $item instanceof Arrayable ? $item->toArray() : $item, $properties);
    }
}
