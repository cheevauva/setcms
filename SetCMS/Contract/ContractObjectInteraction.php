<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface ContractObjectInteraction
{

    public function to(object $object): void;

    public function from(object $object): void;
}
