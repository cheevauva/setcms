<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\Connection\DatabaseMain;
use SetCMS\Core\Entity\DAO\EntityDbRetrieveByCriteriaDAO;
use SetCMS\Module\Post\PostEntityDbMapper;
use SetCMS\Module\Post\PostConstants;

class PostEntityDbRetrieveBySlugDAO extends EntityDbRetrieveByCriteriaDAO
{

    public string $slug;

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = new PostEntityDbMapper;
        $this->table = PostConstants::TABLE_NAME;
        $this->db = $container->get(DatabaseMain::class);
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
