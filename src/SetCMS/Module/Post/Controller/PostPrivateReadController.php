<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\UUID;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('GET')]
class PostPrivateReadController extends PostPrivateController
{

    #[ResponderPassProperty]
    protected ?PostEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    #[\Override]
    protected function units(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->throwExceptionIfNotFound = true;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entity = $object->post ?? null;
        }
    }
}
