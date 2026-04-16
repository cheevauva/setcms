<?php

declare(strict_types=1);

namespace Module\Page\Entity;

use SetCMS\Entity\EntityBasic;

class PageEntity extends EntityBasic
{

    public string $slug;
    public string $title;
    public string $content;
}
