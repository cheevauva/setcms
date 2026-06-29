<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;

class PostCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;
    use \Module\Post\Traits\PostCallTrait;

    public PostEntity $post;

    #[\Override]
    protected function row(): array
    {
        return PostToRowMapper::call($this->container, $this->post)->row;
    }
}
