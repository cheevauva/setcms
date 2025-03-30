<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Common\DAO\Entity\EntityRetrieveManyByCriteriaDAO;
use SetCMS\Module\Page\PageEntity;

class PageRetrieveBySlugDAO extends EntityRetrieveManyByCriteriaDAO
{

    use PageCommonDAO;

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
