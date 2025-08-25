<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Module\UserSession\Mapper\UserSessionMapper;
use SetCMS\Module\UserSession\UserSessionConstrants;

trait UserSessionGenericDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): UserSessionMapper
    {
        return UserSessionMapper::new($this->container);
    }

    protected function table(): string
    {
        return UserSessionConstrants::TABLE_NAME;
    }
}
