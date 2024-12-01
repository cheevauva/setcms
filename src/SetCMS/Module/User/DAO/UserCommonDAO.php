<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Mapper\UserMapper;
use SetCMS\Module\User\UserContstants;

trait UserCommonDAO
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\DatabaseMainConnectionTrait;
    use \SetCMS\Traits\FactoryTrait;

    protected function mapper(): UserMapper
    {
        return UserMapper::make($this->factory());
    }

    protected function table(): string
    {
        return UserContstants::TABLE_NAME;
    }

}
