<?php

declare(strict_types=1);

namespace SetCMS\Core\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Hydratable;
use SetCMS\Core\VO\CorePropertyMessageVO;

class CorePropertyHydrateSevant implements Servant
{

    use \SetCMS\QuickTrait;

    private const TYPES = [
        'int',
        'string',
        'float',
        'bool'
    ];

    public array $array;
    public object $object;
    public array $messages = [];

    private function processProperty(\ReflectionProperty $property): void
    {
        $rawValue = $this->array[$property->getName()] ?? null;
        $rawValueType = gettype($rawValue);
        $propertyType = $property->getType() ? $property->getType()->getName() : null;
        $value = $rawValue;

        if (empty($propertyType)) {
            return;
        }

        if (in_array($propertyType, self::TYPES, true) && !settype($value, $propertyType)) {
            $this->messages[] = new CorePropertyMessageVO('Неверный тип', $property->getName());
            return;
        }

        if ($rawValueType === 'array' && in_array($propertyType, static::TYPES, true)) {
            $this->messages[] = new CorePropertyMessageVO('Массив не может быть преобразован в скалярный тип данных', $property->getName());
            return;
        }

        if ($rawValueType === 'object' && interface_exists($propertyType, true) && !is_a($rawValue, $propertyType, true)) {
            $this->messages[] = new CorePropertyMessageVO('Объект не соответствует интерфейсу', $property->getName());
            return;
        }

        if (class_exists($propertyType, true) && is_subclass_of($propertyType, Hydratable::class, true) && $rawValueType !== 'array') {
            $this->messages[] = new CorePropertyMessageVO('Ожидается массив', $property->getName());
            return;
        }

        if (class_exists($propertyType, true) && !is_subclass_of($propertyType, Hydratable::class, true)) {
            try {
                $value = new $propertyType($rawValue);
            } catch (\Throwable $ex) {
                $this->messages[] = new CorePropertyMessageVO($ex->getMessage(), $property->getName());
                return;
            }
        }

        if (class_exists($propertyType, true) && is_subclass_of($propertyType, Hydratable::class, true)) {
            $value = $this->factory()->make($propertyType);
            $hydrator = CorePropertyHydrateSevant::make($this->factory());
            $hydrator->object = $value;
            $hydrator->array = $this->array[$property->getName()];
            $hydrator->serve();

            foreach ($hydrator->messages as $message) {
                $message = CorePropertyMessageVO::as($message);
                $this->messages[] = new CorePropertyMessageVO(...[
                    $message->message,
                    implode('.', [
                        $property->getName(),
                        $message->field,
                    ])
                ]);
            }
        }

        $this->object->{$property->getName()} = $value ?? $property->getDefaultValue();
    }

    public function serve(): void
    {
        $class = new \ReflectionClass($this->object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $this->processProperty($property);
        }
    }

}
