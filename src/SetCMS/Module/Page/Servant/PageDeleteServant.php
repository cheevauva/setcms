<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageSaveDAO;
use SetCMS\Module\Page\Exception\PageNotFoundException;

class PageDeleteServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public ?PageEntity $page = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = PageRetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->id ?? $this->page->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw new PageNotFoundException;
        }

        $entity = $retrieveById->page;
        $entity->deleted = true;

        $save = PageSaveDAO::make($this->factory());
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

}
