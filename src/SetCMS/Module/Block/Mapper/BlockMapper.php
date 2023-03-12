<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Mapper;

use SetCMS\Entity\Mapper\EntityMapper;
use SetCMS\Module\Block\BlockEntity;

class BlockMapper extends EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): BlockEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['path'] = $this->entity()->path;
        $this->row['params'] = json_encode($this->entity()->params, JSON_UNESCAPED_UNICODE);
        $this->row['template'] = $this->entity()->template;
        $this->row['section'] = $this->entity()->section;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->path = $this->row['path'];
        $this->entity()->params = json_decode($this->row['params'], true);
        $this->entity()->template = $this->row['template'];
        $this->entity()->section = $this->row['section'];
    }

}
