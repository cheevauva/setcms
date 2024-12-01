<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Module\UserSession\Mapper\UserSessionMapper;
use SetCMS\Module\UserSession\UserSessionConstrants;

trait UserSessionGenericDAO
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;
    use \SetCMS\Application\Database\DatabaseMainConnectionTrait;

    protected function mapper(): UserSessionMapper
    {
        return UserSessionMapper::make($this->factory());
    }

    protected function table(): string
    {
        return UserSessionConstrants::TABLE_NAME;
    }

}
