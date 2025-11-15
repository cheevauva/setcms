<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewTwig;
use Module\Page\PageEntity;

class PagePrivateIndexView extends ViewTwig
{

    /**
     * @var PageEntity[]
     */
    public array $pages = [];
}
