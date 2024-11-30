<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Common\Entity\Entity;

class PageEntity extends Entity
{

    use \SetCMS\Traits\AsTrait;

    public $slug;
    public $title;
    public $content;

}
