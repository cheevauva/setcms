<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Controller;
use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\Menu\DAO\MenuRetrieveByIdDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Attribute\ResponderPassProperty;

#[RequestMethod('GET')]
class MenuPrivateEditController extends Controller
{

    #[ResponderPassProperty('menu')]
    protected MenuEntity $entity;

    #[Attributes('id')]
    public UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveByIdDAO::class
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveByIdDAO) {
            $this->entity = $object->menu;
        }
    }
}
