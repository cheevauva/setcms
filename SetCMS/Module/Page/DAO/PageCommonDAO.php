<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Module\Page\Mapper\PageMapper;
use SetCMS\Module\Page\PageConstrants;

trait PageCommonDAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    protected function mapper(): PageMapper
    {
        return PageMapper::new($this->container);
    }

    protected function table(): string
    {
        return PageConstrants::TABLE_NAME;
    }
}
