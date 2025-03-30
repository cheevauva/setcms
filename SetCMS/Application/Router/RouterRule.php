<?php

declare(strict_types=1);

namespace SetCMS\Application\Router;

class RouterRule
{

    protected string $method;
    protected string $rule;
    protected string $name;

    public function rule(string $rule): self
    {
        $this->rule = $rule;

        return $this;
    }

    public function method(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
