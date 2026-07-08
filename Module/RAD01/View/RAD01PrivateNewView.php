<?php

declare(strict_types=1);

namespace Module\RAD01\View;

use SetCMS\View\ViewTwig;

class RAD01PrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'RAD01PrivateEdit';
    }
}
