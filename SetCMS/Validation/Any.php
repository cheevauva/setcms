<?php

declare(strict_types=1);

namespace SetCMS\Validation;

use SplObjectStorage;
use SetCMS\Validation\Exception\ValidationNotEmptyException;

class Any
{

    protected mixed $value;
    protected bool $notEmpty = false;
    protected bool $quiet = true;

    /**
     * @param array<int|string|mixed> $data
     * @param string $path
     * @param SplObjectStorage<\Throwable, mixed> $messages
     */
    public function __construct(array $data, protected string $path, protected SplObjectStorage $messages)
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

        $this->value = $result;
    }

    public function validate(): void
    {
        if ($this->notEmpty && empty($this->value)) {
            $this->throw(new ValidationNotEmptyException());
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
