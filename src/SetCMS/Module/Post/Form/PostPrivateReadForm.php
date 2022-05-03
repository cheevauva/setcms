<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;

class PostPrivateReadForm extends \SetCMS\Form implements \SetCMS\TwigableInterface
{
    private ?PostEntity $post = null;

    public function from(object $object): void
    {
        if ($object instanceof PostEntityDbRetrieveByIdDAO) {
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
