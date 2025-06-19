<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

use SetCMS\Application\Contract\ContractApplicable;

interface ContractTemplateEngineInterface extends ContractApplicable
{

    public function assign(string $name, mixed $value): void;

    /**
     * 
     * @param string $name
     * @param array<string, mixed|object> $context
     * @return string
     */
    public function render(string $name, array $context = []): string;

    public function addFunction(string $name, \Closure $function): void;
}
