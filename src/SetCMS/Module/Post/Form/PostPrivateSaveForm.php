<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Core\Form\FormMessage;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;

class PostPrivateSaveForm extends Form
{

    public string $slug;
    public string $message;
    public string $title;
    private ?PostEntity $post = null;
    
    public function valid(): bool
    {
        if (!empty($this->slug) && !preg_match('/^[a-z0-9_]+$/', $this->slug)) {
            $this->apply(new FormMessage('Только латинские буквы, цифры и подчеркивание', 'slug'));
        }

        return parent::valid();
    }

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PostEntity) {
            $object->slug = $this->slug;
            $object->title = $this->title;
            $object->message = $this->message;
        }
        
        if ($object instanceof PostEntityDbRetrieveByIdDAO) {
            $this->post = $object->entity;
        }
        
        if ($object instanceof PostEntitySaveServant) {
            $object->apply = $this;
            $this->post = $object->entity;
        }
    }
    
    public function toArray(): array
    {
        return [
            'post' => $this->post,
        ];
    }

}
