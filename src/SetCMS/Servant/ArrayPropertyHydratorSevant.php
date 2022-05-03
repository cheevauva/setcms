<?php

declare(strict_types=1);

namespace SetCMS\Servant;

class ArrayPropertyHydratorSevant implements \SetCMS\ServantInterface
{

    public array $array;
    public object $object;
    public \Iterator $messages;

    public function serve(): void
    {
        $this->messages = $this->hydrate();
    }

    protected function hydrate(): \Iterator
    {
        $class = new \ReflectionClass($this->object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof \ReflectionProperty);

            $rawValue = $this->array[$property->getName()] ?? null;
            $rawValueType = gettype($rawValue);
            $propertyType = $property->getType()->getName();
            $value = $rawValue;

            if (!$property->isInitialized($this->object) && empty($rawValue)) {
                yield ['Обязательно для заполнения', $property->getName()];
                continue;
            }

            if ($rawValueType === 'array' && in_array($propertyType, ['int', 'string', 'float', 'bool'], true)) {
                yield ['Массив не может быть преобразован в скалярный тип данных', $property->getName()];
                continue;
            }

            if ($rawValueType === 'object' && interface_exists($propertyType, true) && !is_a($rawValue, $propertyType, true)) {
                yield ['Объект не соответствует интерфейсу', $property->getName()];
                continue;
            }

            if (class_exists($propertyType, true) && is_subclass_of($propertyType, self::class, true) && $rawValueType !== 'array') {
                yield ['Ожидается массив', $property->getName()];
                continue;
            }

            if (class_exists($propertyType, true) && !is_subclass_of($propertyType, self::class, true)) {
                try {
                    $value = new $propertyType($rawValue);
                } catch (\Throwable $ex) {
                    yield [sprintf('Проблема при вызове конструктора: %s', $ex->getMessage()), $property->getName()];
                    continue;
                }
            }

            if (class_exists($propertyType, true) && is_subclass_of($propertyType, self::class, true)) {
                $form = new $propertyType;
                assert($form instanceof self);
                $form->apply($this->object);
                $form->fromArray($this->array[$property->getName()]);
                $form->valid();
            }

            $this->object->{$property->getName()} = $value ?? $property->getDefaultValue();
        }
    }

}
