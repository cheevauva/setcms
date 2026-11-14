<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;

class MenuToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $menu = MenuEntity::as($this->entity);

        $this->row['label'] = $menu->label;
        $this->row['route'] = $menu->route;
        $this->row['params'] = $this->json($menu->params);

        parent::run();
    }
}
