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
    protected bool $quiet = true;
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
            $this->throw(new ValidationNotEmptyException($this->path));
        }
    }

    protected function throw(\Throwable $ex): void
    {
        if ($this->quiet) {
            $this->messages->attach($ex, $this->path);
        } else {
            throw $ex;
        }
    }

    public function quiet(): static
    {
        $this->quiet = true;

        return $this;
    }

    public function notQuiet(): static
    {
        $this->quiet = false;

        return $this;
    }

    public function notEmpty(): static
    {
        $this->notEmpty = true;

        return $this;
    }
}
