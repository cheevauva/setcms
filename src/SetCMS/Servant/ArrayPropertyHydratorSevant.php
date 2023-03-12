<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Hydratable;

class ArrayPropertyHydratorSevant implements Servant
{

    private const TYPES = [
        'int',
        'string',
        'float',
        'bool'
    ];

    public array $array;
    public object $object;
    public ?array $messages = null;

    private function processProperty(\ReflectionProperty $property): void
    {
        $rawValue = $this->array[$property->getName()] ?? null;
        $rawValueType = gettype($rawValue);
        $propertyType = $property->getType() ? $property->getType()->getName() : null;
        $value = $rawValue;

        if (empty($propertyType)) {
            return;
        }

        if (!$property->isInitialized($this->object) && !is_array($rawValue) && empty($rawValue)) {
            $this->messages[] = ['Обязательно для заполнения', $property->getName()];
            return;
        }

        if (in_array($propertyType, self::TYPES, true) && !settype($value, $propertyType)) {
            $this->messages[] = ['Неверный тип', $property->getName()];
            return;
        }

        if ($rawValueType === 'array' && in_array($propertyType, static::TYPES, true)) {
            $this->messages[] = ['Массив не может быть преобразован в скалярный тип данных', $property->getName()];
            return;
        }

        if ($rawValueType === 'object' && interface_exists($propertyType, true) && !is_a($rawValue, $propertyType, true)) {
            $this->messages[] = ['Объект не соответствует интерфейсу', $property->getName()];
            return;
        }

        if (class_exists($propertyType, true) && is_subclass_of($propertyType, Hydratable::class, true) && $rawValueType !== 'array') {
            $this->messages[] = ['Ожидается массив', $property->getName()];
            return;
        }

        if (class_exists($propertyType, true) && !is_subclass_of($propertyType, Hydratable::class, true)) {
            try {
                $value = new $propertyType($rawValue);
            } catch (\Throwable $ex) {
                $this->messages[] = [$ex->getMessage(), $property->getName()];
                return;
            }
        }

        if (class_exists($propertyType, true) && is_subclass_of($propertyType, Hydratable::class, true)) {
            $value = new $propertyType;
            $hydrator = new ArrayPropertyHydratorSevant;
            $hydrator->object = $value;
            $hydrator->array = $this->array[$property->getName()];
            $hydrator->serve();

            foreach ($hydrator->messages as $message) {
                $this->messages[] = [
                    $message[0],
                    implode('.', [
                        $property->getName(),
                        $message[1]
                    ])
                ];
            }
        }

        $this->object->{$property->getName()} = $value ?? $property->getDefaultValue();
    }

    public function serve(): void
    {
        $this->messages = [];

        $class = new \ReflectionClass($this->object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $this->processProperty($property);
        }
    }

}
