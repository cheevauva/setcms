<?php

declare(strict_types=1);

namespace SetCMS\Contract;

use SetCMS\Contract\Applicable;

interface Template extends Applicable
{

    public function render(string $name, array $context = []): string;

    public function has(string $name): bool;
}
