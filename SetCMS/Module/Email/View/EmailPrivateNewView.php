<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\View;

use SetCMS\View\ViewTwig;

class EmailPrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'EmailPrivateEdit';
    }
}
