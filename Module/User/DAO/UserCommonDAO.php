<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\UserConstants;

trait UserCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return UserConstants::TABLE_NAME;
    }
}
