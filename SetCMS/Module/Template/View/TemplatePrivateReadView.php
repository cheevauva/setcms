<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Template\Entity\TemplateEntity;

class TemplatePrivateReadView extends ViewTwig
{

    public TemplateEntity $template;
}
