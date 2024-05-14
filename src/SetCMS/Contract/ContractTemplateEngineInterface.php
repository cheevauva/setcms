<?php

declare(strict_types=1);

namespace SetCMS\Contract;

use SetCMS\Contract\Applicable;

interface ContractTemplateEngineInterface extends Applicable
{

    public function assign(string $name, mixed $value): void;

    public function render(string $name, array $context = []): string;

    public function has(string $name): bool;
}
