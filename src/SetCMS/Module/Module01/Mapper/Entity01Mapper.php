<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Module01\Entity\Entity01Entity;

class Entity01Mapper extends EntityMapper
{

    use \SetCMS\Traits\FactoryTrait;

    protected function entity(): Entity01Entity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['field01'] = $this->entity()->field01;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->field01 = $this->row['field01'];
    }

}
