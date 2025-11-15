<?php

declare(strict_types=1);

namespace Module\Template\View;

use SetCMS\View\ViewJson;
use Module\Template\Entity\TemplateEntity;

class TemplatePrivateUpdateView extends ViewJson
{

    public ?TemplateEntity $template = null;
}
