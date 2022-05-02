<?php

declare(strict_types=1);

namespace SetCMS;

interface AttributableInterface
{

    public function withAttribute(string $attribute, mixed $value): void;

    public function withoutAttribute(string $attribute): void;

    public function getAttribute(string $attribute, mixed $default = null): mixed;
}
