<?php

declare(strict_types=1);

namespace SetCMS;

trait AttributableTrait
{

    private array $attributes = [];

    public function getAttribute(string $attribute, mixed $default = null): mixed
    {
        return $this->attributes[$attribute] ?? $default;
    }

    public function withAttribute(string $attribute, mixed $value): void
    {
        $this->attributes[$attribute] = $value;
    }

    public function withoutAttribute(string $attribute): void
    {
        unset($this->attributes[$attribute]);
    }

}
