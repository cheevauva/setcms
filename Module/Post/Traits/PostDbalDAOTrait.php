<?php

declare(strict_types=1);

namespace Module\Post\Traits;

use Module\Post\PostConstrants;

trait PostDbalDAOTrait
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return PostConstrants::TABLE_NAME;
    }
}
