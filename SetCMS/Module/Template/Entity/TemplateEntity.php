<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Entity;

use SetCMS\Common\Entity\Entity;

class TemplateEntity extends Entity
{

    public string $slug;
    public string $title;
    public string $template;
}
