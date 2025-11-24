<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewTwig;
use Module\Page\Entity\PageEntity;

class PagePublicReadView extends ViewTwig
{

    public PageEntity $page;
}
