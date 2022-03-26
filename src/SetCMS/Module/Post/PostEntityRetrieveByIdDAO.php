<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use SetCMS\Core\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Post\PostEntityDbMapper;

class PostEntityRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    public function __construct()
    {
        $this->mapper = new PostEntityDbMapper;
        $this->table = PostConstants::TABLE_NAME;
    }

}
