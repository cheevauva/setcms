<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;

class PostRetrieveBySlugDAO extends EntityRetrieveByCriteriaDAO
{

    use PostGenericDAO;

    public string $slug;

    public function serve(): void
    {
        $this->criteria = [
            'slug' => $this->slug,
            'deleted' => 0,
        ];

        parent::serve();
    }

}
