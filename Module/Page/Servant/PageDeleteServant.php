<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\DAO\PageUpdateDAO;
use Module\Page\Servant\PageGetByIdServant;

class PageDeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    protected function run(): void
    {
        $page = PageGetByIdServant::call($this, $this->id)->page;
        $page->markDeleted();

        PageUpdateDAO::call($this, $page);
    }
}
