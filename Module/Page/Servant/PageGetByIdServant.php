<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageRetrieveByCriteriaDAO;

class PageGetByIdServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $getOne = PageRetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->limit = 1;
        $getOne->serve();

        $this->page = $getOne->page;
    }
}
