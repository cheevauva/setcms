<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\DAO\PageUpdateDAO;
use Module\Page\Servant\PageGetByIdServant;

class PageDeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    public function serve(): void
    {
        $page = PageGetByIdServant::call($this->container, $this->id)->page;
        $page->markDeleted();

        PageUpdateDAO::call($this->container, $page);
    }
}
