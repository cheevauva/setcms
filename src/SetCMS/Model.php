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

    protected function removeValidationMessages()
    {
        foreach ($this->messages as $index => $message) {
            if (!empty($message['validation'])) {
                unset($this->messages[$index]);
            }
        }
    }

    public function isValid(): bool
    {
        $this->removeValidationMessages();
        
        if (empty($this->messages)) {
            $this->validate();
        }
        
        return empty($this->messages);
    }

    protected function validate(): void
    {
        $reflect = new ReflectionObject($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof ReflectionProperty);

            $comment = $property->getDocComment();

            if (!$property->getValue($this) && strpos($comment, VarDoc::REQUIRED) !== false) {
                $this->addMessageAsValidation('Поле обязательно для заполнения', $property->getName());
            }
        }
    }

    public function clearMessages(): void
    {
        $this->messages = [];
    }

    protected function addMessageAsValidation(string $message, ?string $field = null): void
    {
        $this->messages[] = [
            'message' => $message,
            'field' => $field,
            'validation' => true,
        ];
    }

    public function addMessage(string $message, ?string $field = null): void
    {
        $this->messages[] = [
            'message' => $message,
            'field' => $field,
            'validation' => false,
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
            $comment = $property->getDocComment();
            $value = $array[$property->getName()] ?? $property->getValue($this);

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

        return $this;
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
