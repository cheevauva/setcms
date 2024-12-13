<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use SetCMS\Scope;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\Menu\DAO\MenuRetrieveByIdDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuPrivateEditScope extends Scope
{

    protected ?MenuEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveByIdDAO) {
            $this->entity = $object->menu;
        }
    }

    public function toArray(): array
    {
        return [
            'menu' => $this->entity,
        ];
    }
}
