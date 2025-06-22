<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\View;

use SetCMS\View\ViewTwig;

class Entity01PrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'Entity01PrivateEdit';
    }
}
