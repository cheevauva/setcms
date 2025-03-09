<?php

declare(strict_types=1);

namespace UUA;

interface UnitInterface extends ContainerConstructInterface
{

    public function serve(): void;
}
