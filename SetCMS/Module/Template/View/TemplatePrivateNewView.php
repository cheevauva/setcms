<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\View;

use SetCMS\View\ViewTwig;

class TemplatePrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'TemplatePrivateEdit';
    }
}
