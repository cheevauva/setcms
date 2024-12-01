<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

interface ContractValidateInterface
{

    /**
     * Return not satisfy messages
     * @return \Iterator
     */
    public function validate(): \Iterator;
}
