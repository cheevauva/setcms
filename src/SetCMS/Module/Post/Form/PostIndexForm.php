<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Scope;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\Contract\Twigable;

class PostIndexForm extends Scope implements Twigable
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
