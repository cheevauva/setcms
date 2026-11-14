<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<MenuEntity>
 */
class MenuFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $this->entity = new MenuEntity();
        $this->entity->id = $this->uuid('id');
        $this->entity->label = $this->string('label');
        $this->entity->route = $this->string('route');
        $this->entity->params = $this->json('params');

        parent::run();
    }
}
