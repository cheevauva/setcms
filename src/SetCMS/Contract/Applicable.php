<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface Applicable
{

    public function to(object $object): void;
    public function from(object $object): void;
}
