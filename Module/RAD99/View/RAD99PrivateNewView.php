<?php

declare(strict_types=1);

namespace Module\RAD99\View;

use SetCMS\View\ViewTwig;

class RAD99PrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'RAD99PrivateEdit';
    }
}
