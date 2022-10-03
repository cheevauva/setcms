<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

class PostEntityRetrieveBySlugDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use PostEntityDbDAOTrait;

    public bool $throwExceptions = true;
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
