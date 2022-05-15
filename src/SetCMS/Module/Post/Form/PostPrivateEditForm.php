<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Form;

use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\PostEntity;

class PostPrivateEditForm extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
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
