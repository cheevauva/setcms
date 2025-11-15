<?php

declare(strict_types=1);

namespace Module\Template\View;

use SetCMS\View\ViewTwig;

class TemplatePrivateIndexView extends ViewTwig
{

    /**
     * @var \Module\Template\Entity\TemplateEntity[]
     */
    public array $templates = [];
}
