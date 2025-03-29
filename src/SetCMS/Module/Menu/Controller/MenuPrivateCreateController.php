<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Controller;
use SetCMS\Module\Menu\DAO\MenuSaveDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Attribute\ResponderPassProperty;

#[RequestMethod('POST')]
class MenuPrivateCreateController extends Controller
{

    protected ?MenuEntity $entity = null;

    #[Body('menu')]
    #[ResponderPassProperty]
    public MenuPrivateMenuScope $menu;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuSaveDAO::class
        ];
    }

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
}
