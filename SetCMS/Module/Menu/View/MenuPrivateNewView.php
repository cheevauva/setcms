<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\View;

class MenuPrivateNewView extends \SetCMS\View\ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'MenuPrivateEdit';
    }
}
