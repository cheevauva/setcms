<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageHasByIdDAO;
use SetCMS\Module\Page\DAO\PageSaveDAO;
use SetCMS\Module\Page\Exception\PageAlreadyExistsException;

class PageCreateServant implements Servant
{

    use \SetCMS\DITrait;

    public PageEntity $page;

    public function serve(): void
    {
        $hasEntityById = PageHasByIdDAO::make($this->factory());
        $hasEntityById->id = $this->page->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new PageAlreadyExistsException;
        }

        $saveEntity = PageSaveDAO::make($this->factory());
        $saveEntity->page = $this->page;
        $saveEntity->serve();
    }

}
