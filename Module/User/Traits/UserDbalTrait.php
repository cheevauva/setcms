<?php

declare(strict_types=1);

namespace Module\User\Traits;

use Module\User\UserConstants;

trait UserDbalTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return UserConstants::TABLE_NAME;
    }
}
