<?php

declare(strict_types=1);

namespace Module\UserSession\Traits;

use Module\UserSession\UserSessionConstrants;

trait UserSessionDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return UserSessionConstrants::TABLE_NAME;
    }
}
