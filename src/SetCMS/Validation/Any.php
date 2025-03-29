<?php

declare(strict_types=1);

namespace SetCMS\Validation;

use SplObjectStorage;
use SetCMS\Validation\Exception\ValidationNotEmptyException;

class Any
{

    protected string $path;
    protected mixed $value;
    protected bool $notEmpty = false;
    protected SplObjectStorage $messages;

    public function __construct(array $data, string $path, SplObjectStorage $messages)
    {

        $paths = explode('.', $path);
        $result = $data;

        foreach ($paths as $key) {
            if (!isset($result[$key])) {
                $result = null;
                break;
            }

            $result = $result[$key];
        }
        
        $this->path = $path;
        $this->value = $result;
        $this->messages = $messages;
    }

    public function validate(): void
    {
        if ($this->notEmpty && empty($this->value)) {
            $this->messages->attach(new ValidationNotEmptyException(), $this->path);
        }
    }

    public function notEmpty(): static
    {
        $this->notEmpty = true;

        return $this;
    }
}
