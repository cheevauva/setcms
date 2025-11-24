<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewJson;
use Module\Page\Entity\PageEntity;

class PagePrivateUpdateView extends ViewJson
{

    public ?PageEntity $entity = null;
}
