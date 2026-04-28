<?php

declare(strict_types=1);

namespace Module\Page\Traits;

use Module\Page\PageConstrants;

trait PageDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return PageConstrants::TABLE_NAME;
    }
}
