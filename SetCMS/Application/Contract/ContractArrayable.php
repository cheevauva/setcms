<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

interface ContractArrayable
{

    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
