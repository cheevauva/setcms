<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use Module\Menu\Entity\MenuEntity;

class MenuSaveDAO extends EntitySaveDAO
{

    use MenuCommonDAO;

    public MenuEntity $menu;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->menu;

        parent::serve();
    }
}
