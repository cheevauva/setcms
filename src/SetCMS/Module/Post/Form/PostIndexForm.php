<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Form;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\TwigableInterface;

class PostIndexForm extends Form implements TwigableInterface
{

    private ?\Iterator $posts = null;

    public function from(object $object): void
    {
        if ($object instanceof PostEntityDbRetrieveManyByCriteriaDAO) {
            $this->posts = $object->entities;
        }
    }

    public function toArray(): array
    {
        return [
            'posts' => $this->posts,
        ];
    }

}
