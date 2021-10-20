<?php

namespace SetCMS\Module\Posts\PostModel;

use SetCMS\Module\Posts\Post;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class PostModelSave extends OrdinaryModel
{

    public string $id = '';

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

    protected function validate(): void
    {
        if (!empty($this->slug) && !preg_match('/^[a-z0-9_]+$/', $this->slug)) {
            $this->addMessageAsValidation('Только латинские буквы, цифры и подчеркивание', 'slug');
        }
        
        parent::validate();
    }

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): Post
    {
        assert($entity instanceof Post);

        $entity->id = $this->id;
        $entity->slug = $this->slug;
        $entity->title = $this->title;
        $entity->message = $this->message;

        return $entity;
    }

}
