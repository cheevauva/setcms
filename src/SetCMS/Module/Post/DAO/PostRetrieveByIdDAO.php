<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Post\PostEntity;

class PostRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use PostGenericDAO;

    public ?PostEntity $post;

    public function serve(): void
    {
        parent::serve();

        $this->post = $this->entity;
    }

}
