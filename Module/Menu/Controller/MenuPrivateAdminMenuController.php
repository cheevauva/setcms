<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Menu\View\MenuPrivateAdminMenuView;

class MenuPrivateAdminMenuController extends ControllerViaPSR7
{

    /**
     * @var array<int,array<mixed>>
     */
    protected array $items;

    #[\Override]
    protected function process(): void
    {
        $rootPath = $this->container->get('rootPath');

        if (file_exists($rootPath . 'cache/module/menu/adminMenu.php')) {
            $this->items = require $rootPath . 'cache/module/menu/adminMenu.php';
        } else {
            $this->items = require $rootPath . 'resources/module/menu/adminMenu.php';
        }
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateAdminMenuView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuPrivateAdminMenuView) {
            $object->items = $this->items;
        }
    }
}
