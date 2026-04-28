<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;

class PostGetByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public PostEntity $post;

    #[\Override]
    public function serve(): void
    {
        $getById = PostRetrieveManyByCriteriaDAO::new($this->container);
        $getById->expectOne = true;
        $getById->allowEmptyResult = false;
        $getById->id = $this->id;
        $getById->deleted = false;
        $getById->serve();
        
        $this->post = $getById->post;
    }
}
