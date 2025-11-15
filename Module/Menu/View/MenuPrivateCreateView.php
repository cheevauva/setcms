<?php

declare(strict_types=1);

namespace Module\Menu\View;

use Module\Menu\Entity\MenuEntity;

class MenuPrivateCreateView extends \SetCMS\View\ViewJson
{

    public MenuEntity $menu;
}
