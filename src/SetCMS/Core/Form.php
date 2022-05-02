<?php

declare(strict_types=1);

namespace SetCMS\Core;

use SetCMS\ApplyInterface;
use SetCMS\AttributableInterface;
use SetCMS\Core\Form\FormMessageStorage;
use SetCMS\Core\Form\Message\FormMessage;
use SetCMS\Core\Form\Message\FormMessagePopulate;

class Form implements ApplyInterface, AttributableInterface
{

    use \SetCMS\AttributableTrait;

    private ?Form $parent = null;
    private FormMessageStorage $messages;

    public function __construct()
    {
        $this->messages = new FormMessageStorage;
    }

    public function valid(): bool
    {
        return $this->messages->count() === 0;
    }

    public function apply(object $object): void
    {
        if ($object instanceof Form) {
            $this->parent = $object;
        }

        if ($object instanceof \Throwable) {
            $this->apply(new FormMessage($object->getMessage(), get_class($object)));
        }

        if ($object instanceof FormMessage) {
            $this->messages->attach($object);
            $this->parent ? $this->parent->apply($object) : null;
        }
    }

    private function resetMessages()
    {
        foreach ($this->messages as $message) {
            if ($message instanceof FormMessagePopulate) {
                $this->messages->detach($message);
            }
        }
    }

    public function from(object $object): void
    {
        
    }

    public function to(object $object): void
    {
        
    }

    public function fromArray(array $array): void
    {
        $class = new \ReflectionClass($this);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof \ReflectionProperty);

            $rawValue = $array[$property->getName()] ?? null;
            $rawValueType = gettype($rawValue);
            $propertyType = $property->getType()->getName();
            $value = $rawValue;

            if (!$property->isInitialized($this) && !isset($rawValue)) {
                $this->apply(new FormMessagePopulate('required' . $property));
                continue;
            }

            if ($rawValueType === 'array' && in_array($propertyType, ['int', 'string', 'float', 'bool'], true)) {
                $this->apply(new FormMessagePopulate('wrong type !array' . $property));
                continue;
            }

            if ($rawValueType === 'object' && interface_exists($propertyType, true) && !is_a($rawValue, $propertyType, true)) {
                $this->apply(new FormMessagePopulate('wrong type !interface' . $property));
                continue;
            }

            if (class_exists($propertyType, true) && is_subclass_of($propertyType, self::class, true) && $rawValueType !== 'array') {
                $this->apply(new FormMessagePopulate('wrong type !array 2form' . $property));
                continue;
            }

            if (class_exists($propertyType, true) && !is_subclass_of($propertyType, self::class, true)) {
                try {
                    $value = new $propertyType($rawValue);
                } catch (\Throwable $ex) {
                    $this->apply(new FormMessagePopulate('wrong type !construct type' . $ex->getMessage() . $property));
                    continue;
                }
            }

            if (class_exists($propertyType, true) && is_subclass_of($propertyType, self::class, true)) {
                $form = new $propertyType;
                assert($form instanceof self);
                $form->apply($this);
                $form->fromArray($array);
                $form->valid();
            }

            $this->{$property->getName()} = $value ?? $property->getDefaultValue();
        }
    }

    public function getMessages(): array
    {
        $messages = [];

        foreach ($this->messages as $message) {
            if ($message instanceof FormMessage) {
                $messages[] = $message->toArray();
            }
        }

        return $messages;
    }

    public function toArray(): array
    {
        return [];
    }

}
