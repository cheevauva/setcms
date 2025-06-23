<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\View;

use SetCMS\View\ViewTwig;

class TemplatePrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\Template\Entity\TemplateEntity[]
     */
    public array $templates = [];
}
