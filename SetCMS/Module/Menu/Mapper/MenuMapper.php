<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = MenuEntity::as($this->entity);

        $this->row['label'] = $entity->label;
        $this->row['route'] = $entity->route;
        $this->row['params'] = json_encode($entity->params, JSON_UNESCAPED_UNICODE);
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = MenuEntity::as($this->entity);
        $entity->label = $this->row['label'];
        $entity->route = $this->row['route'];
        $entity->params = json_decode($this->row['params'], true);
    }
}
