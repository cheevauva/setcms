<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\UserContstants;

trait UserCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return UserContstants::TABLE_NAME;
    }
}
