<?php

declare(strict_types=1);

namespace SetCMS\Core;

interface ApplyInterface
{

    public function apply(object $object): void;
}
