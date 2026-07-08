<?php

declare(strict_types=1);

namespace Module\RAD01\Mapper;

use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Exception\RAD01MapperNotFoundKeyInRowException;

class RAD01FromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public RAD01Entity $rad01;

    #[\Override]
    public function serve(): void
    {
        $this->rad01 = new RAD01Entity();
        $this->rad01->field01 = $this->string('field01');
        $this->id($this->rad01);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): RAD01MapperNotFoundKeyInRowException
    {
        return new RAD01MapperNotFoundKeyInRowException($key);
    }
}
