<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Scope;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Contract\Applicable;

class PostPrivateSaveForm extends Scope implements Applicable
{

    public string $slug;
    public string $message;
    public string $title;
    private ?PostEntity $post = null;

    public function satisfy(): \Iterator
    {
        if (!empty($this->slug) && !preg_match('/^[a-zA-Z0-9_]+$/', $this->slug)) {
            yield ['Только латинские буквы, цифры и подчеркивание', 'slug'];
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof PostEntity) {
            $object->slug = $this->slug;
            $object->title = $this->title;
            $object->message = $this->message;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof PostEntitySaveServant) {
            $object->apply = $this;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PostEntityDbRetrieveByIdDAO) {
            $this->post = $object->entity;
        }

        if ($object instanceof PostEntitySaveServant) {
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
