<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Post\PostEntity;

class PostMapper extends EntityMapper
{

    use \SetCMS\Traits\FactoryTrait;

    protected function entity(): PostEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['message'] = $this->entity()->message;
        $this->row['slug'] = $this->entity()->slug;
        $this->row['title'] = $this->entity()->title;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->message = $this->row['message'];
        $this->entity()->title = $this->row['title'];
        $this->entity()->slug = $this->row['slug'];
    }

}
