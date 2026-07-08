<?php

declare(strict_types=1);

namespace Module\RAD99\Traits;

use Module\RAD99\RAD99Constants;

trait RAD99DbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return RAD99Constants::TABLE_NAME;
    }
}
