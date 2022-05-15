<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface Applicable
{

    public function apply(object $object): void;
}
