<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\Page\PageEntity;

class PagePrivateCreateView extends ViewJson
{

    public ?PageEntity $page = null;
}
