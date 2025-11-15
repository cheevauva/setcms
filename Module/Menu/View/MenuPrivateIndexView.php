<?php

declare(strict_types=1);

namespace Module\Menu\View;

use Module\Menu\Entity\MenuEntity;

class MenuPrivateIndexView extends \SetCMS\View\ViewTwig
{

    /**
     * @var MenuEntity[]
     */
    public array $menus;
}
