<?php

declare(strict_types=1);

namespace Module\Menu\View;

use SetCMS\View\ViewTwig;

class MenuPublicActionsView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'block/PublicActionMenu';
    }
}
