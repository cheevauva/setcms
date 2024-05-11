<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\UUID;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Attribute\Http\Parameter\Attributes;

class PostPrivateReadScope extends PostPrivateScope
{

    protected ?PostEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof PostRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->throwExceptionIfNotFound = true;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof PostRetrieveByIdDAO) {
            $this->entity = $object->post ?? null;
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->entity,
        ];
    }

}
