<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Module\Page\DAO\PageRetrieveByCriteriaDAO;
use Module\Page\Entity\PageEntity;

class PageGetByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\CallWithUUIDTrait;

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $getOne = PageRetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->serve();

        $this->page = $getOne->page;
    }
}
