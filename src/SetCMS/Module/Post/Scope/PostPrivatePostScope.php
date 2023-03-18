<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Attribute;
use SetCMS\Module\Post\PostEntity;
use SetCMS\UUID;

class PostPrivatePostScope extends PostPrivateScope
{

    public UUID $id;

    #[Attribute\NotBlank]
    public string $slug;

    #[Attribute\NotBlank]
    public string $message;

    #[Attribute\NotBlank]
    public string $title;

    public function satisfy(): \Iterator
    {
        parent::satisfy();

        if (0) {
            yield ['', ''];
        }
    }

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
