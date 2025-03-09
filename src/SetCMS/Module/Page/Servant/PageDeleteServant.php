<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use SetCMS\UUID;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageSaveDAO;
use SetCMS\Module\Page\Exception\PageNotFoundException;

class PageDeleteServant extends \UUA\Servant
{

    public ?PageEntity $page = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $pageById = PageRetrieveByIdDAO::new($this->container);
        $pageById->id = $this->page->id ?? ($this->id ?? throw new \RuntimeException('id is not defined'));
        $pageById->serve();

        if (!$pageById->first) {
            throw new PageNotFoundException;
        }

        $page = PageEntity::as($pageById->first);
        $page->deleted = true;

        $save = PageSaveDAO::new($this->container);
        $save->entity = $page;
        $save->serve();

        $this->page = $page;
    }
}
