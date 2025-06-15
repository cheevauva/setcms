<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Common\Entity\Entity;

class PageEntity extends Entity
{

    public string $slug;
    public string $title;
    public string $content;
}
