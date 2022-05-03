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

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PostEntityDbRetrieveBySlugDAO) {
            $object->slug = $this->slug;
            $this->post = $object->entity;
        }
    }
    
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['entity'] = $this->post;
        
        return $array;
    }

}
