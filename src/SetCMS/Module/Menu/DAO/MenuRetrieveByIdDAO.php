<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

use SetCMS\Common\DAO\Entity\EntityRetrieveByIdDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use MenuCommonDAO;

    public MenuEntity $menu;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->menu = $this->entity;
    }
}
