<?php

declare(strict_types=1);

namespace SetCMS\DTO;

use SetCMS\ControllerViaPSR7;

class SetCMSOutputDTO extends \UUA\DTO
{

    public bool $isSuccess = true;
    protected array $data = [];
    protected array $messages = [];
    protected ControllerViaPSR7 $finalScope;

    public function finalScope(?ControllerViaPSR7 $controller = null): ?ControllerViaPSR7
    {
        if (is_null($controller)) {
            return $this->finalScope ?? null;
        }

        return $this->finalScope = $controller;
    }

    public function addMessage(mixed $message): void
    {
        $this->messages[] = $message;
    }

    public function set(string $var, mixed $value): void
    {
        $this->data[$var] = $value;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
