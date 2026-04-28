<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Mapper\PostToRowMapper;

class PostUpdateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityUpdateTrait;
    use \Module\Post\Traits\PostCallTrait;
    use \Module\Post\Traits\PostDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return PostToRowMapper::call($this->container, $this->post)->row;
    }
}
