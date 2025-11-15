<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use Module\UserSession\Mapper\UserSessionMapper;
use Module\UserSession\UserSessionConstrants;

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
