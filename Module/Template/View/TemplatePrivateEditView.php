<?php

declare(strict_types=1);

namespace Module\Template\View;

use Module\Template\Entity\TemplateEntity;

class TemplatePrivateEditView extends TemplatePrivateReadView
{

    public TemplateEntity $template;
}
