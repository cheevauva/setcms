<?php

declare(strict_types=1);

namespace Module\RAD01\Traits;

use Module\RAD01\RAD01Constants;

trait RAD01DbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return RAD01Constants::TABLE_NAME;
    }
}
