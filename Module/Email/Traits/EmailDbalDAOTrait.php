<?php

declare(strict_types=1);

namespace Module\Email\Traits;

use Module\Email\EmailConstrants;

trait EmailDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return EmailConstrants::TABLE_NAME;
    }
}
