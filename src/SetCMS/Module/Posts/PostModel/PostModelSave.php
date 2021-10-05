<?php

namespace SetCMS\Module\Posts\PostModel;

use SetCMS\Module\Posts\Post;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelSave;

class PostModelSave extends OrdinaryModelSave
{


    /**
     * @setcms-required
     * @var string 
     */
    public string $slug = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $message = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $title = '';

    public function prepareEntity()
    {
        $entity = $this->entity();

        assert($entity instanceof Post);

        $entity->id = $this->id;
        $entity->slug = $this->slug;
        $entity->title = $this->title;
        $entity->message = $this->message;
    }

}
