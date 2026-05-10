<?php

declare(strict_types=1);

namespace Module\Menu\View;

use Module\Menu\Entity\MenuEntity;

class MenuPrivateReadView extends \SetCMS\View\ViewTwig
{
    public MenuEntity $menu;
}
