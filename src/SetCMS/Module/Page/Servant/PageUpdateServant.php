<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageHasByIdDAO;
use SetCMS\Module\Page\DAO\PageSaveDAO;
use SetCMS\Module\Page\Exception\PageNotFoundException;

class PageUpdateServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public PageEntity $page;

    public function serve(): void
    {
        $hasById = PageHasByIdDAO::make($this->factory());
        $hasById->id = $this->page->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new PageNotFoundException;
        }

        $saveEntity = PageSaveDAO::make($this->factory());
        $saveEntity->page = $this->page;
        $saveEntity->serve();
    }

}
