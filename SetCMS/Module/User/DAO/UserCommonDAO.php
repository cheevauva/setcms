<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Mapper\UserMapper;
use SetCMS\Module\User\UserContstants;

trait UserCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): UserMapper
    {
        return UserMapper::new($this->container);
    }

    protected function table(): string
    {
        return UserContstants::TABLE_NAME;
    }
}
