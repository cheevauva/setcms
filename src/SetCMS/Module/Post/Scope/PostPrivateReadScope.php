<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Contract\Twigable;
use SetCMS\UUID;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;

class PostPrivateReadScope extends PostPrivateScope implements Twigable
{

    protected ?PostEntity $entity = null;
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof PostRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PostRetrieveByIdDAO) {
            $this->entity = $object->post;
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->entity,
        ];
    }

}
