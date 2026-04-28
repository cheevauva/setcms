<?php

declare(strict_types=1);

namespace Module\Module99\Traits;

use Module\Module99\Module99Constants;

trait Entity99DbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return Module99Constants::TABLE_NAME;
    }
}
