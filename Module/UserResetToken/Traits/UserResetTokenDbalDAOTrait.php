<?php

declare(strict_types=1);

namespace Module\UserResetToken\Traits;

use Module\UserResetToken\UserResetTokenConstants;

trait UserResetTokenDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return UserResetTokenConstants::TABLE_NAME;
    }
}
