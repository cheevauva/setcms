<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Scope;

class PostPrivatePostScope extends Scope
{

    public string $slug;
    public string $message;
    public string $title;

    public function satisfy(): \Iterator
    {
        if (!empty($this->slug) && !preg_match('/^[a-zA-Z0-9_]+$/', $this->slug)) {
            yield ['Только символ подчеркивание, латинские буквы и цифры', 'slug'];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostEntity) {
            $object->slug = $this->slug;
            $object->message = $this->message;
            $object->title = $this->title;
        }
    }


}
