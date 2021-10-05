<?php

namespace SetCMS;

use SetCMS\VarDoc;
use ReflectionObject;
use ReflectionProperty;

abstract class Model
{

    protected array $messages = [];

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

        return '';
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
            assert($property instanceof ReflectionProperty);

            $value = $array[$property->getName()] ?? $property->getValue($this);

            $comment = $property->getDocComment();

            if (!empty($value) && strpos($comment, VarDoc::TYPE_DATETIME) !== false) {
                try {
                    $value = new \DateTime($value);
                } catch (\Exception $ex) {
                    $value = null;
                    $this->messages[] = sprintf('Форма ожидает строку в формате DateTime в поле "%s", возможно указан неверный формат', $property->getName());
                }
            }

            $this->{$property->getName()} = $value;
        }
        
        return $this;
    }

    abstract public function toArray(): array;
}
