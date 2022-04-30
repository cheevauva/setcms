<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Core\Entity\DAO\EntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\PostEntityDbMapper;
use SetCMS\Module\Post\PostConstants;

class PostEntityDbRetrieveByIdDAO extends EntityDbRetrieveByIdDAO
{

    public function __construct()
    {
        $this->mapper = new PostEntityDbMapper;
        $this->table = PostConstants::TABLE_NAME;
    }

}
