<?php

declare(strict_types=1);

namespace Module\Menu\View;

use SetCMS\View\ViewTwig;
use SetCMS\Compiler;

class MenuPrivateAdminMenuView extends ViewTwig
{

    /**
     * @var array<int,array<mixed>>
     */
    public array $items = [];

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->items = Compiler::singleton($this->container)->getAsArray('adminMenu');
    }

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'block/PrivateMainMenu';
    }
}
