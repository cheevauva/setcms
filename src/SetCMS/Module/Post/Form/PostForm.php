<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\PostEntityRetrieveBySlugDAO;
use SetCMS\Core\Form\FormMessage;

class PostForm extends Form
{

    public string $id;
    public string $slug;
    public string $message;
    public string $title;

    public function isValid(): bool
    {
        if (!empty($this->slug) && !preg_match('/^[a-z0-9_]+$/', $this->slug)) {
            $this->apply(new FormMessage('Только латинские буквы, цифры и подчеркивание', 'slug'));
        }

        return parent::isValid();
    }

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PostEntity) {
            $object->id = $this->id;
            $object->slug = $this->slug;
            $object->title = $this->title;
            $object->message = $this->message;
        }

        if ($object instanceof PostEntityRetrieveBySlugDAO) {
            $object->slug = $this->slug;
        }
    }

}
