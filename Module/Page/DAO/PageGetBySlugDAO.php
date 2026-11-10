<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Module\Page\DAO\PageRetrieveByCriteriaDAO;
use Module\Page\Entity\PageEntity;

class PageGetBySlugDAO extends \UUA\DAO
{

    public string $slug;
    public protected(set) PageEntity $page;

    #[\Override]
    protected function run(): void
    {
        $getBySlug = PageRetrieveByCriteriaDAO::new($this->container);
        $getBySlug->expectOne = true;
        $getBySlug->allowEmptyResult = false;
        $getBySlug->slug = $this->slug;
        $getBySlug->limit = 1;
        $getBySlug->serve();

        $this->page = $getBySlug->page;
    }
}
