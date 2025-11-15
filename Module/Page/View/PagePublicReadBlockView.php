<?php

declare(strict_types=1);

namespace Module\Page\View;

use Module\Page\PageEntity;

class PagePublicReadBlockView extends \SetCMS\View\ViewTwig
{

    public ?PageEntity $page;
    public string $slug;
}
