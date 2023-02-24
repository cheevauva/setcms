<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;

class PostRetrieveBySlugDAO extends EntityRetrieveByCriteriaDAO
{

    use PostGenericDAO;

    public string $slug;
    public ?PostEntity $post;

    public function serve(): void
    {
        $this->criteria = [
            'slug' => $this->slug,
            'deleted' => 0,
        ];

        parent::serve();

        $this->post = $this->entity;
    }

}
