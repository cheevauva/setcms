<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewTwig;
use Module\Page\PageEntity;

class PagePrivateReadView extends ViewTwig
{

    public ?PageEntity $page = null;
}
