<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Page\PageEntity;

class PagePrivateReadView extends ViewTwig
{

    public ?PageEntity $page = null;
}
