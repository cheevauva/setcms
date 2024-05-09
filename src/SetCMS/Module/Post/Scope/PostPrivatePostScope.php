<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Attribute\NotBlank;
use SetCMS\Module\Post\PostEntity;
use SetCMS\UUID;

class PostPrivatePostScope extends PostPrivateScope
{

    public UUID $id;

    #[NotBlank]
    public string $slug;

    #[NotBlank]
    public string $message;

    #[NotBlank]
    public string $title;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostEntity) {
            $object->id = $this->id;
            $object->slug = $this->slug;
            $object->message = $this->message;
            $object->title = $this->title;
        }
    }

}
