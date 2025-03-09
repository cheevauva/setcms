<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Attribute\NotBlank;
use SetCMS\Module\Post\PostEntity;
use SetCMS\UUID;

class PostPrivatePostController extends PostPrivateController
{

    public UUID $id;

    #[NotBlank]
    public string $slug;

    #[NotBlank]
    public string $message;

    #[NotBlank]
    public string $title;

    #[\Override]
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
