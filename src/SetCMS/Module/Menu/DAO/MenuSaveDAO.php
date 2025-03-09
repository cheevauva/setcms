<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

use SetCMS\Common\DAO\Entity\EntitySaveDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;

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
