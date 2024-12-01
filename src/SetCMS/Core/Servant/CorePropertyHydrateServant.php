<?php

declare(strict_types=1);

namespace SetCMS\Core\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Application\Contract\ContractHydrateInterface;
use SetCMS\Core\VO\CorePropertyMessageVO;

class CorePropertyHydrateServant implements ContractServant
{

    use \SetCMS\Traits\QuickTrait;

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

        if (is_null($value)) {
            try {
                $this->object->{$property->getName()} = $value;
                return;
            } catch (\Throwable $ex) {
                return;
            }
        }

        if (in_array($propertyType, self::TYPES, true)) {
            if (settype($value, $propertyType)) {
                $this->object->{$property->getName()} = $value;
                return;
            } else {
                $this->messages[] = new CorePropertyMessageVO('Неверный тип', $property->getName());
                return;
            }
        }

        if ($rawValueType === 'array' && in_array($propertyType, static::TYPES, true)) {
            $this->messages[] = new CorePropertyMessageVO('Массив не может быть преобразован в скалярный тип данных', $property->getName());
            return;
        }

        if ($rawValueType === 'object' && interface_exists($propertyType, true) && !is_a($rawValue, $propertyType, true)) {
            $this->messages[] = new CorePropertyMessageVO('Объект не соответствует интерфейсу', $property->getName());
            return;
        }

        if (class_exists($propertyType, true) && is_subclass_of($propertyType, ContractHydrateInterface::class, true) && $rawValueType !== 'array') {
            $this->messages[] = new CorePropertyMessageVO('Ожидается массив', $property->getName());
            return;
        }

        if (class_exists($propertyType, true) && !is_subclass_of($propertyType, ContractHydrateInterface::class, true)) {
            if (empty($value) || !is_scalar($value)) {
                return;
            }

            try {
                if (is_a($propertyType, \UnitEnum::class, true)) {
                    $this->object->{$property->getName()} = $propertyType::from($rawValue);
                } else {
                    $this->object->{$property->getName()} = new $propertyType($rawValue);
                }
            } catch (\Throwable $ex) {
                $this->messages[] = new CorePropertyMessageVO($ex->getMessage(), $property->getName());
                return;
            }
        }

        if (is_object($rawValue) && class_exists(get_class($rawValue), true) && interface_exists($propertyType, true) && is_subclass_of($rawValue, $propertyType, true)) {
            $this->object->{$property->getName()} = $value;
        }

        if (class_exists($propertyType, true) && is_subclass_of($propertyType, ContractHydrateInterface::class, true)) {
            $hydrator = CorePropertyHydrateServant::make($this->factory());
            $hydrator->object = $this->object->{$property->getName()} = new $propertyType;
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
