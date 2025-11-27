<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\PostConstrants;

trait PostCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return PostConstrants::TABLE_NAME;
    }
}
