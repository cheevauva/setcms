<?php

namespace SetCMS\Module\Posts\PostModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Posts\Post;
use SetCMS\Module\Ordinary\OrdinaryEntity;

class PostModelCreate extends OrdinaryModel
{

    public string $slug = '';
    public string $title = '';
    public string $message = '';

    public function bind(OrdinaryEntity $entity): Post
    {
        assert($entity instanceof Post);

        $entity->slug = $this->slug;
        $entity->title = $this->title;

        return $entity;
    }

}
