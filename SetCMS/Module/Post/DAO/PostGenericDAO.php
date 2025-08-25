<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Module\Post\Mapper\PostMapper;
use SetCMS\Module\Post\PostConstrants;

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
