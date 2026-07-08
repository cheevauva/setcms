<?php

declare(strict_types=1);

namespace Module\RAD99\Mapper;

use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\Exception\RAD99MapperNotFoundKeyInRowException;

class RAD99FromRowMapper extends \Module\Basic\Mapper\BasicEntityFromRowMapper
{

    public RAD99Entity $rad99;

    #[\Override]
    public function serve(): void
    {
        $this->rad99 = new RAD99Entity();
        $this->rad99->field99 = $this->string('field99');
        $this->id($this->rad99);
        $this->basic($this->rad99);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): RAD99MapperNotFoundKeyInRowException
    {
        return new RAD99MapperNotFoundKeyInRowException($key);
    }
}
