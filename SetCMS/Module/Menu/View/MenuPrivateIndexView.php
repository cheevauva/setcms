<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\View;

use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuPrivateIndexView extends \SetCMS\View\ViewTwig
{

    /**
     * @var MenuEntity[]
     */
    public array $menus;
}
