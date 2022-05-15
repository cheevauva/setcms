<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\ServantInterface;
use SetCMS\Hydratable;

class ArrayPropertyHydratorSevant implements ServantInterface
{

    public array $array;
    public object $object;
    public ?array $messages = null;

    public function serve(): void
    {
        $this->messages = [];

        $class = new \ReflectionClass($this->object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof \ReflectionProperty);

            $rawValue = $this->array[$property->getName()] ?? null;
            $rawValueType = gettype($rawValue);
            $propertyType = $property->getType()->getName();
            $value = $rawValue;

            if (!$property->isInitialized($this->object) && !is_array($rawValue) && empty($rawValue)) {
                $this->messages[] = ['Обязательно для заполнения', $property->getName()];
                continue;
            }

            if ($rawValueType === 'array' && in_array($propertyType, ['int', 'string', 'float', 'bool'], true)) {
                $this->messages[] = ['Массив не может быть преобразован в скалярный тип данных', $property->getName()];
                continue;
            }

            if ($rawValueType === 'object' && interface_exists($propertyType, true) && !is_a($rawValue, $propertyType, true)) {
                $this->messages[] = ['Объект не соответствует интерфейсу', $property->getName()];
                continue;
            }


            if (class_exists($propertyType, true) && is_subclass_of($propertyType, Hydratable::class, true) && $rawValueType !== 'array') {
                $this->messages[] = ['Ожидается массив', $property->getName()];
                continue;
            }


            if (class_exists($propertyType, true) && !is_subclass_of($propertyType, Hydratable::class, true)) {
                try {
                    $value = new $propertyType($rawValue);
                } catch (\Throwable $ex) {
                    $this->messages[] = [sprintf('Проблема при вызове конструктора: %s', $ex->getMessage()), $property->getName()];
                    continue;
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
    }

}
