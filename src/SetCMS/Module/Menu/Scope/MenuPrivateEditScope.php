<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use SetCMS\Scope;
use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\Menu\DAO\MenuRetrieveByIdDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuPrivateEditScope extends Scope
{

    protected ?MenuEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveByIdDAO) {
            $object->id = $this->id;
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

    #[\Override]
    public function toArray(): array
    {
        return [
            'menu' => $this->entity,
        ];
    }
}
