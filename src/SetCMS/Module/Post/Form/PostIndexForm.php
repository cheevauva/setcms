<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\TwigableInterface;

class PostIndexForm extends Form implements TwigableInterface
{

    private ?\Iterator $posts = null;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PostEntityDbRetrieveManyByCriteriaDAO) {
            $this->posts = $object->entities;
        }
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['posts'] = $this->posts;

        return $array;
    }

}
