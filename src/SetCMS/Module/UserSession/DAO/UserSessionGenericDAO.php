<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Module\UserSession\Mapper\UserSessionMapper;
use SetCMS\Module\UserSession\UserSessionConstrants;

trait UserSessionGenericDAO
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): UserSessionMapper
    {
        return UserSessionMapper::make($this->factory());
    }

    protected function table(): string
    {
        return UserSessionConstrants::TABLE_NAME;
    }

}
