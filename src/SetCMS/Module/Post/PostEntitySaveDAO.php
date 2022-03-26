<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Container\ContainerInterface;
use SetCMS\Core\Entity\DAO\EntitySaveDAO;
use SetCMS\Module\Post\PostEntityDbMapper;
use SetCMS\Module\Post\PostConstants;

class PostEntitySaveDAO extends EntitySaveDAO
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = $container->get(PostEntityDbMapper::class);
        $this->table = PostConstants::TABLE_NAME;
    }

}
