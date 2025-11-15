<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewTwig;

class PagePrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'PagePrivateEdit';
    }
}
