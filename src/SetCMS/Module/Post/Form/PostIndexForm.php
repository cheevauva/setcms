<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyByCriteriaDAO;
use SetCMS\TwigableInterface;

class PostIndexForm extends Form implements TwigableInterface
{

    private ?array $pages = null;

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['entities'] = $this->pages;

        return $array;
    }

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PostEntityDbRetrieveManyByCriteriaDAO) {
            $this->pages = $object->entities ? iterator_to_array($object->entities) : null;
        }
    }

}
