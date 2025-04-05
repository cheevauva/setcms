<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\View;

use SetCMS\View\ViewTwig;

class MenuPublicActionsViaContextView extends ViewTwig
{

    /**
     * @var MenuActionEntity[]
     */
    public array $items = [];

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'block/PublicContextActions';
    }
}
