<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

class PostEntityDbRetrieveBySlugDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use PostEntityDbDAOTrait;

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
