<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\Exception\PostNotFoundException;

class PostRetrieveBySlugDAO extends EntityRetrieveByCriteriaDAO
{

    use PostGenericDAO;

    public string $slug;
    public ?PostEntity $post;
    public bool $throwExceptionIfNotFound = false;

    public function serve(): void
    {
        $this->criteria = [
            'slug' => $this->slug,
            'deleted' => 0,
        ];

        parent::serve();
        
        if (empty($this->entity) && $this->throwExceptionIfNotFound) {
            throw new PostNotFoundException;
        }

        $this->post = $this->entity;
    }

}
