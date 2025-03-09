<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Block\BlockEntity;

class BlockMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();
        
        $entity = BlockEntity::as($this->entity);
        
        $this->row['path'] = $entity->path;
        $this->row['params'] = json_encode($entity->params, JSON_UNESCAPED_UNICODE);
        $this->row['template'] = $entity->template;
        $this->row['section'] = $entity->section;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = BlockEntity::as($this->entity);
        $entity->path = $this->row['path'] ?? throw new \RuntimeException('row.path is undefined');
        $entity->params = json_decode($this->row['params'] ?? '{}', true);
        $entity->template = $this->row['template']  ?? throw new \RuntimeException('row.template is undefined');
        $entity->section = $this->row['section'] ?? throw new \RuntimeException('row.section is undefined');
    }
}
