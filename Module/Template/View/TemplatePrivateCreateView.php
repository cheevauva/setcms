<?php

declare(strict_types=1);

namespace Module\Template\View;

use Module\Template\Entity\TemplateEntity;

class TemplatePrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?TemplateEntity $template = null;
}
