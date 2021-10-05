<?php

namespace SetCMS;

abstract class Module
{

    private string $module;

    public function __construct(string $module)
    {
        $this->module = $module;
    }

    abstract public function getPrefix(): string;

    public function __toString(): string
    {
        return $this->module;
    }

    public function getDefaultAction(): string
    {
        return 'index';
    }

}
