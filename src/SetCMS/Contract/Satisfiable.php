<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface Satisfiable
{

    /**
     * Return not satisfy messages
     * @return \Iterator
     */
    public function satisfy(): \Iterator;
}
