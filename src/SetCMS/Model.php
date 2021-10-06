<?php

namespace SetCMS;

use SetCMS\VarDoc;
use ReflectionObject;
use ReflectionProperty;

abstract class Model
{

    protected array $messages = [];

    protected const TYPE_INT = 'int';
    protected const TYPE_DATETIME = 'datetime';
    protected const TYPES = [
        VarDoc::TYPE_INT => self::TYPE_INT,
        VarDoc::TYPE_DATETIME => self::TYPE_DATETIME,
    ];

    public function isValid(): bool
    {
        $reflect = new ReflectionObject($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof ReflectionProperty);

            $comment = $property->getDocComment();

            if (!$property->getValue($this) && strpos($comment, VarDoc::REQUIRED) !== false) {
                $this->addMessage(sprintf('Поле "%s", но оно не заполнено', $property->getName()), $property->getName());
            }
        }

        return empty($this->messages);
    }

    public function addMessage(string $message, $field = null): void
    {
        $this->messages[] = [
            'message' => $message,
            'field' => $field,
        ];
    }

    public function getFirstMessage(?string $field = null): string
    {
        foreach ($this->messages as $message) {
            if ($message['field'] === $field) {
                return $message['message'] ?? '';
            }
        }

        return reset($this->messages)['message'] ?? '';
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function fromArray(array $array): self
    {
        $reflect = new ReflectionObject($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $this->set($property, $array[$property->getName()] ?? $property->getValue($this));
        }

        return $this;
    }

    public function set($property, $value)
    {
        if (!($property instanceof ReflectionProperty)) {
            $property = (new ReflectionObject($this))->getProperty($property);
        }

        assert($property instanceof ReflectionProperty);

        $comment = $property->getDocComment();

        foreach (self::TYPES as $vardoc => $type) {
            if (strpos($comment, $vardoc) === false) {
                continue;
            }

            try {
                $value = $this->convert($type, $value);
            } catch (ModelException $ex) {
                throw ModelException::invalidField($property->getName());
            }
        }

        $property->setValue($this, $value);
    }

    private function convert(string $type, $value)
    {
        switch ($type) {
            case self::TYPE_INT:
                if ($value == intval($value) && $value !== '') {
                    return intval($value);
                }
                break;
            case self::TYPE_DATETIME:
                try {
                    return new \DateTime($value);
                } catch (\Exception $ex) {
                    
                }
                break;
            default:
                return $value;
        }

        throw ModelException::convertFail($value);
    }

    abstract public function toArray(): array;
}
