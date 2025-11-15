<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewJson;
use Module\Page\PageEntity;

class PagePrivateCreateView extends ViewJson
{

    public ?PageEntity $page = null;
}
