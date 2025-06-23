<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\View;

use SetCMS\Module\Template\Entity\TemplateEntity;

class TemplatePrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?TemplateEntity $template = null;
}
