<?php

declare(strict_types=1);

namespace Module\Template\View;

use SetCMS\View\ViewTwig;
use Module\Template\Entity\TemplateEntity;

class TemplatePrivateReadView extends ViewTwig
{

    public TemplateEntity $template;
}
