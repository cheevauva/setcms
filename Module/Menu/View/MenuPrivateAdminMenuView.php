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

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'block/PrivateMainMenu';
    }
}
