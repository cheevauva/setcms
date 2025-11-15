<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\UUID;
use Module\Page\PageEntity;
use Module\Page\DAO\PageSaveDAO;
use Module\Page\Exception\PageNotFoundException;
use Module\Page\DAO\PageRetrieveManyByCriteriaDAO;

class PageDeleteServant extends \UUA\Servant
{

    public ?PageEntity $page = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $pageById = PageRetrieveManyByCriteriaDAO::new($this->container);
        $pageById->id = $this->page->id ?? ($this->id ?? throw new \RuntimeException('id is not defined'));
        $pageById->serve();

        if (!$pageById->page) {
            throw new PageNotFoundException;
        }

        $page = PageEntity::as($pageById->page);
        $page->deleted = true;

        $save = PageSaveDAO::new($this->container);
        $save->page = $page;
        $save->serve();

        $this->page = $page;
    }
}
