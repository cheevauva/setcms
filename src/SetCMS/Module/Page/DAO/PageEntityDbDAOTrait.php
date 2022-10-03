<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Module\Page\Mapper\PageEntityDbMapper;
use SetCMS\Module\Page\PageConstants;

trait PageEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): PageEntityDbMapper
    {
        return PageEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return PageConstants::TABLE_NAME;
    }

}
