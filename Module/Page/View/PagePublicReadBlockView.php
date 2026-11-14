<?php

declare(strict_types=1);

namespace Module\Page\View;

use Module\Page\Entity\PageEntity;

class PagePublicReadBlockView extends \SetCMS\View\ViewTwig
{

    public PageEntity $entity;
    public string $slug;
}
