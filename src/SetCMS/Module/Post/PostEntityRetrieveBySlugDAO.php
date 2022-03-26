<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use SetCMS\Core\Entity\DAO\EntityRetrieveByCriteriaDAO;
use SetCMS\Module\Post\PostEntityDbMapper;

class PostEntityRetrieveBySlugDAO extends EntityRetrieveByCriteriaDAO
{

    public string $slug;

    public function __construct()
    {
        $this->mapper = new PostEntityDbMapper;
        $this->table = PostConstants::TABLE_NAME;
    }

    public function serve(): void
    {
        $this->criteria = [
            'slug' => $this->slug,
            'deleted' => 0,
        ];

        parent::serve();
    }

}
