<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuMapper extends EntityMapper
{

    use \SetCMS\Traits\FactoryTrait;

    #[\Override]
    protected function entity(): MenuEntity
    {
        return parent::entity();
    }

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();
        
        $this->row['label'] = $this->entity()->label;
        $this->row['route'] = $this->entity()->route;
        $this->row['params'] = json_encode($this->entity()->params, JSON_UNESCAPED_UNICODE);
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();
        
        $this->entity()->label = $this->row['label'];
        $this->entity()->route = $this->row['route'];
        $this->entity()->params = json_decode($this->row['params'], true);
    }
}
