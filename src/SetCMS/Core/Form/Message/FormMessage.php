<?php

declare(strict_types=1);

namespace SetCMS\Core\Form\Message;

class FormMessage
{

    protected $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
        ];
    }

}
