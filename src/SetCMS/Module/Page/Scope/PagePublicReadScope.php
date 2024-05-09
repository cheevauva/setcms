<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Scope;
use SetCMS\UUID;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Attribute\Http\Parameter\Attributes;

class PagePublicReadScope extends Scope
{

    protected ?PageEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof PageRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->throwExceptionIfNotFound = true;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PageRetrieveByIdDAO) {
            $this->entity = $object->page;
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->entity,
        ];
    }

}
