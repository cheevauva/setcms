<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

interface ContractApplicable
{

    public function to(object $object): void;

    public function from(object $object): void;
}
