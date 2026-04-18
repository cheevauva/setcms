<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\DAO\PageUpdateDAO;
use Module\Page\DAO\PageGetByIdDAO;

class PageDeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\CallWithUUIDTrait;

    #[\Override]
    public function serve(): void
    {
        $page = PageGetByIdDAO::call($this->container, $this->id)->page;
        $page->markDeleted();

        PageUpdateDAO::call($this->container, $page);
    }
}
