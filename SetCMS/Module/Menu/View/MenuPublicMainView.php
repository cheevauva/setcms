<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\View;

use SetCMS\View\ViewTwig;

class MenuPublicMainView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'block/PublicMainMenu';
    }
}
