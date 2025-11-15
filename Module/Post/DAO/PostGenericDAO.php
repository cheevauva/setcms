<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Mapper\PostMapper;
use Module\Post\PostConstrants;

trait PostGenericDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): PostMapper
    {
        return PostMapper::new($this->container);
    }

    protected function table(): string
    {
        return PostConstrants::TABLE_NAME;
    }
}
