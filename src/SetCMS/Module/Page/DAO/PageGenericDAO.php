<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Module\Page\Mapper\PageMapper;
use SetCMS\Module\Page\PageConstrants;

trait PageGenericDAO
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;
    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    protected function mapper(): PageMapper
    {
        return PageMapper::make($this->factory());
    }

    protected function table(): string
    {
        return PageConstrants::TABLE_NAME;
    }

}
