<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Form;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;
use SetCMS\TwigableInterface;
use SetCMS\Module\Post\PostEntity;

class PostReadBySlugForm extends Form implements TwigableInterface
{

    public string $slug;
    private ?PostEntity $post = null;

    public function to(object $object): void
    {
        if ($object instanceof PostEntityDbRetrieveBySlugDAO) {
            $object->slug = $this->slug;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PostEntityDbRetrieveBySlugDAO) {
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
