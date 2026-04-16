<?php

declare(strict_types=1);

namespace Module\Template\Entity;

use SetCMS\Entity\EntityBasic;

class TemplateEntity extends EntityBasic
{

    public string $slug;
    public string $title;
    public string $template;
}
