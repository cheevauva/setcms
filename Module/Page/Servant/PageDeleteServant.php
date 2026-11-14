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
        $entity = PageGetByIdServant::call($this, $this->id)->entity;
        $entity->markDeleted();

        PageUpdateDAO::call($this, $entity);
    }
}
