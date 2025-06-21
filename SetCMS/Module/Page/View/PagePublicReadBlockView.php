<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\View;

use SetCMS\Module\Page\PageEntity;

class PagePublicReadBlockView extends \SetCMS\View\ViewTwig
{

    public ?PageEntity $page;
    public string $slug;
}
