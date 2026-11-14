<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;

class MenuToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = MenuEntity::as($this->entity);

        $this->row['label'] = $entity->label;
        $this->row['route'] = $entity->route;
        $this->row['params'] = $this->json($entity->params);

        parent::run();
    }
}
