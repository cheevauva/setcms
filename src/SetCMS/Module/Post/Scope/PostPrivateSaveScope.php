<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\PostEntity;

class PostPrivateSaveScope extends \SetCMS\Entity\Scope\EntitySaveScope
{

    public string $slug;
    public string $message;
    public string $title;

    public function __construct()
    {
        $this->entity = new PostEntity;
    }

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

    public function toArray(): array
    {
        return [
            'post' => $this->entity,
        ];
    }

}
