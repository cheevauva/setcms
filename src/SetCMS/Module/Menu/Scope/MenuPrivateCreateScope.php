<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use SetCMS\Scope;
use SetCMS\Module\Menu\DAO\MenuSaveDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\Attribute\Http\Parameter\Body;

class MenuPrivateCreateScope extends Scope
{

    protected ?MenuEntity $entity = null;

    #[Body('menu')]
    public MenuPrivateMenuScope $menu;

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof MenuSaveDAO) {
            $this->entity = $object->menu;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof MenuSaveDAO) {
            $this->entity = new MenuEntity();
            $this->menu->to($this->entity);
            //
            $object->menu = $this->entity;
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
