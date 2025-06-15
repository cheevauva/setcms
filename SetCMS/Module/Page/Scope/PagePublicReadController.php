<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\UUID;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Attribute\Http\Parameter\Attributes;

class PagePublicReadScope extends ControllerViaPSR7
{

    protected ?PageEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

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
