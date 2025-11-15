<?php

declare(strict_types=1);

namespace Module\Page\View;

use Module\Page\PageEntity;

class PagePrivateUpdateView extends \SetCMS\View\ViewJson
{

    public ?PageEntity $page = null;
}
