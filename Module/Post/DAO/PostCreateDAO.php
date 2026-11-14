<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;

class PostCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return PostToRowMapper::call($this, $this->entity)->row;
    }
}
