<?php

declare(strict_types=1);

namespace Module\Page\View;

use SetCMS\View\ViewTwig;

class PagePrivateIndexView extends ViewTwig
{

    /**
     * @var \Module\Page\Entity\PageEntity[]
     */
    public array $entities = [];
}
