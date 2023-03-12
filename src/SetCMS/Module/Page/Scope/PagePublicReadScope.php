<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Scope;
use SetCMS\UUID;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;

class PagePublicReadScope extends Scope
{

    protected ?PageEntity $entity = null;
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof PageRetrieveByIdDAO) {
            $object->id = $this->id;
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
