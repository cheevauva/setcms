<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\Module\Menu\View\MenuPrivateIndexView;

class MenuPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var MenuEntity[]
     */
    protected array $menus = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $this->menus = $object->menus;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuPrivateIndexView) {
            $object->menus = $this->menus;
        }
    }
}
