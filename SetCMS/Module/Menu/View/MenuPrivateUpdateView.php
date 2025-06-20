<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\View;

use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuPrivateUpdateView extends \SetCMS\View\ViewJson
{

    public MenuEntity $menu;
}
