<?php

declare(strict_types=1);

namespace Module\Menu\View;

use SetCMS\View\ViewTwig;

class MenuPrivateAdminMenuView extends ViewTwig
{

    /**
     * @var array<int,array<mixed>>
     */
    public array $items = [];

    protected function init(): void
    {
        parent::init();

        $rootPath = $this->container->get('rootPath');

        if (file_exists($rootPath . 'cache/module/menu/adminMenu.php')) {
            $this->items = require $rootPath . 'cache/module/menu/adminMenu.php';
        } else {
            $this->items = require $rootPath . 'resources/module/menu/adminMenu.php';
        }
    }

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'block/PrivateMainMenu';
    }
}
