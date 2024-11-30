<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Common\DAO\Entity\EntityRetrieveByIdDAO;
use SetCMS\Module\Post\PostEntity;

class PostRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use PostGenericDAO;
    use \SetCMS\FactoryTrait;

    public ?PostEntity $post;

    public function serve(): void
    {
        parent::serve();

        $this->post = $this->entity;
    }

}
