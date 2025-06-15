<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Page\PageEntity;

class PagePrivateIndexView extends ViewTwig
{

    /**
     * @var PageEntity[]
     */
    public array $pages = [];
}
