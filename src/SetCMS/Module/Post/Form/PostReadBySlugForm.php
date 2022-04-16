<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;

class PostReadBySlugForm extends Form
{

    public string $slug;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PostEntityDbRetrieveBySlugDAO) {
            $object->slug = $this->slug;
        }
    }

}
