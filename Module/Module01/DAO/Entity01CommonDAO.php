<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Module\Module01\Module01Constrants;

trait Entity01CommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return Module01Constrants::TABLE_NAME;
    }
}
