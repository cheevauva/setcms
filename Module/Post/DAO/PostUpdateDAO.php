<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Mapper\PostToRowMapper;

class PostUpdateDAO extends \SetCMS\Entity\DAO\EntityUpdateDAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return PostToRowMapper::call($this, $this->entity)->row;
    }
}
