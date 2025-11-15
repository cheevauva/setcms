<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface ContractArrayable
{

    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
