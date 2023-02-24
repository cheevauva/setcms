<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Entity\DAO\EntitySaveDAO;
use SetCMS\Module\Post\PostEntity;

class PostSaveDAO extends EntitySaveDAO
{

    use PostGenericDAO;

    public PostEntity $post;

    public function serve(): void
    {
        $this->entity = $this->post;

        parent::serve();
    }

}
