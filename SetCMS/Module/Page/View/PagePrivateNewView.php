<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\View;

use SetCMS\View\ViewTwig;

class PagePrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'PagePrivateEdit';
    }
}
