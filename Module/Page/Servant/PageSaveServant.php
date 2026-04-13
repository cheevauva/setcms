<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageHasByIdDAO;
use Module\Page\DAO\PageCreateDAO;
use Module\Page\DAO\PageUpdateDAO;

class PageSaveServant extends \UUA\Servant
{

    use \SetCMS\Servant\EntitySaveServantTrait;

    public PageEntity $page;

    #[\Override]
    protected function hasById(): bool
    {
        return PageHasByIdDAO::call($this->container, $this->page->id)->isExists;
    }

    #[\Override]
    protected function create(): void
    {
        PageCreateDAO::call($this->container, $this->page);
    }

    #[\Override]
    protected function update(): void
    {
        PageUpdateDAO::call($this->container, $this->page);
    }
}
