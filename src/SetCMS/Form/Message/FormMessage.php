<?php

declare(strict_types=1);

namespace SetCMS\Form\Message;

class FormMessage
{

    protected string $message;
    protected string $field;

    public function __construct(string $message, string $field)
    {
        $this->message = $message;
        $this->field = $field;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'field' => $this->field,
        ];
    }

}
