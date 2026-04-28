<?php

declare(strict_types=1);

namespace Module\Module99\Mapper;

use Module\Module99\Entity\Entity99Entity;
use Module\Module99\Exception\Entity99MapperNotFoundKeyInRowException;

class Entity99FromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowBasicTrait;

    public Entity99Entity $entity99;

    #[\Override]
    public function serve(): void
    {
        $this->entity99 = new Entity99Entity();
        $this->entity99->field99 = $this->string('field99');

        $this->mappingDefault($this->entity99);
        $this->mappingBasic($this->entity99);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new Entity99MapperNotFoundKeyInRowException($key);
    }
}
