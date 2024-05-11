<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface ContractScopeInterface
{

    public function getMessages(): array;

    public function hasMessages(): bool;

    public function from(object $object): void;

    public function to(object $object): void;
}
