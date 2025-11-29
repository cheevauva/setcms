<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Module\Module01\Module01Constants;

trait Entity01CommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return Module01Constants::TABLE_NAME;
    }
}
