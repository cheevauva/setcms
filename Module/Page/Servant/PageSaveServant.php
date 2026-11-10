<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\DAO\PageHasByIdDAO;
use Module\Page\DAO\PageCreateDAO;
use Module\Page\DAO\PageUpdateDAO;

class PageSaveServant extends \UUA\Servant
{

    use \Module\Page\Traits\PageCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (PageHasByIdDAO::call($this, $this->page->id)->isExists) {
            PageUpdateDAO::call($this, $this->page);
        } else {
            PageCreateDAO::call($this, $this->page);
        }
    }
}
