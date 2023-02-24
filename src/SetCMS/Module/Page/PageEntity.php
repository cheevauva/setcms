<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Entity;

class PageEntity extends Entity
{

    use \SetCMS\AsTrait;

    public $slug;
    public $title;
    public $content;

}
