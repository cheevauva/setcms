<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Module\Page\PageConstrants;

trait PageCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return PageConstrants::TABLE_NAME;
    }
}
