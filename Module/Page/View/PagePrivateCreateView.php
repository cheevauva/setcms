<?php

declare(strict_types=1);

namespace Module\Page\View;

use Module\Page\Entity\PageEntity;

class PagePrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?PageEntity $entity = null;
}
