<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use SetCMS\Module\Page\PageEntity;

class PageRetrieveBySlugDAO extends EntityRetrieveByCriteriaDAO
{

    use PageGenericDAO;

    public string $slug;
    public ?PageEntity $page;

    public function serve(): void
    {
        $this->criteria = [
            'slug' => $this->slug,
            'deleted' => 0,
        ];
        
        parent::serve();

        $this->page = $this->entity;
    }

}
