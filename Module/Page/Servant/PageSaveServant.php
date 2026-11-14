<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\DAO\PageHasByIdDAO;
use Module\Page\DAO\PageCreateDAO;
use Module\Page\DAO\PageUpdateDAO;

class PageSaveServant extends \UUA\Servant
{

    use \SetCMS\Entity\Traits\EntityCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (PageHasByIdDAO::call($this, $this->entity->id)->isExists) {
            PageUpdateDAO::call($this, $this->entity);
        } else {
            PageCreateDAO::call($this, $this->entity);
        }
    }
}
