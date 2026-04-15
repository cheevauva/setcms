<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageDeleteByIdDAO;
use Module\Page\DAO\PageUpdateDAO;
use Module\Page\DAO\PageGetByIdDAO;

class PageDeleteServant extends \UUA\Servant
{

    use \SetCMS\Servant\EntityDeleteServantTrait;

    protected PageEntity $page;

    #[\Override]
    protected function delete(): void
    {
        PageDeleteByIdDAO::call($this->container, $this->id);
    }

    #[\Override]
    protected function entity(): PageEntity
    {
        return $this->page ??= PageGetByIdDAO::call($this->container, $this->id)->page;
    }

    #[\Override]
    protected function update(): void
    {
        PageUpdateDAO::call($this->container, $this->entity());
    }
}
