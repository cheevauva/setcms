<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\Template\Entity\TemplateEntity;

class TemplatePrivateUpdateView extends ViewJson
{

    public ?TemplateEntity $template = null;
}
