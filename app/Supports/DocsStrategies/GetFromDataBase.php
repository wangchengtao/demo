<?php

declare(strict_types=1);

namespace App\Supports\DocsStrategies;

use App\Supports\Attributes\Message;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Attributes\GenericParam;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Strategies\Strategy;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionEnum;
use ReflectionEnumUnitCase;
use ReflectionFunctionAbstract;
use ReflectionUnionType;
use Spatie\LaravelData\Data;

class GetFromDataBase extends Strategy
{
    use ParamHelpers;

    protected string $attributeName;

    public function __invoke(ExtractedEndpointData $endpointData, array $settings = []): array
    {
        if ($dataClass = $this->getDataReflectionClass($endpointData->method)) {
            $parent = $dataClass->getParentClass();

            if ($parent) {
                $parentParams = $this->extractAttributes($parent);
            }

            return array_merge(
                $parentParams ?? [],
                $this->extractAttributes($dataClass),
            );
        }

        return [];
    }

    protected function extractAttributes(ReflectionClass $reflectionClass): array
    {
        $c = collect($reflectionClass->getAttributes($this->attributeName))
            ->flatMap(function (ReflectionAttribute $attribute) {
                $param = $attribute->newInstance();

                $arr = $param->toArray();
                $arr['enumValues'] = $this->extractEnumValues($param);

                return [
                    $param->name => $arr,
                ];
            })
            ->toArray();

        return array_map([$this, 'normalizeParameterData'], $c);
    }

    protected function extractEnumValues(GenericParam $param): array
    {
        if (is_string($param->enum) && enum_exists($param->enum) && method_exists($param->enum, 'tryFrom')) {
            $enum = new ReflectionEnum($param->enum);

            return collect($enum->getCases())
                ->flatMap(function (ReflectionEnumUnitCase $case) {
                    return collect($case->getAttributes(Message::class))
                        ->flatMap(fn (ReflectionAttribute $attr) => [
                            $attr->newInstance()->value . ': ' . $case->getValue()->value,
                        ]);
                })->toArray();
        }

        return $param->enum ?? [];
    }

    protected function normalizeParameterData(array $data): array
    {
        $data['type'] = static::normalizeTypeName($data['type']);
        if (is_null($data['example'])) {
            $data['example'] = $this->generateDummyValue($data['type'], [
                'name' => $data['name'],
                'enumValues' => $data['enumValues'],
            ]);
        } elseif ($data['example'] === 'No-example' || $data['example'] === 'No-example.') {
            $data['example'] = null;
        }

        if ($data['required']) {
            $data['nullable'] = false;
        }

        $data['description'] = trim($data['description'] ?? '');

        return $data;
    }

    protected function getDataReflectionClass(ReflectionFunctionAbstract $method): ?ReflectionClass
    {
        foreach ($method->getParameters() as $argument) {
            $argType = $argument->getType();
            if ($argType === null || $argType instanceof ReflectionUnionType) {
                continue;
            }

            $argumentClassName = $argType->getName();

            if (! class_exists($argumentClassName)) {
                continue;
            }

            $argumentClass = new ReflectionClass($argumentClassName);

            if ($argumentClass->isSubclassOf(Data::class)) {
                return $argumentClass;
            }
        }

        return null;
    }
}
