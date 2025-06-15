<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\View;

use SetCMS\Module\Page\PageEntity;

class PagePrivateUpdateView extends \SetCMS\View\ViewJson
{

    public ?PageEntity $page = null;
}
