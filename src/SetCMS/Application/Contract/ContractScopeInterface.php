<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

interface ContractScopeInterface
{

    public function from(object $object): void;

    public function to(object $object): void;
}
