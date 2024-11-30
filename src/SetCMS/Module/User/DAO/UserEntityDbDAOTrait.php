<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Mapper\UserEntityDbMapper;
use SetCMS\Module\User\UserContstants;

trait UserEntityDbDAOTrait
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\Traits\FactoryTrait;

    protected function mapper(): UserEntityDbMapper
    {
        return UserEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return UserContstants::TABLE_NAME;
    }

}
