<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Page\PageEntity;

class PageMapper extends EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): PageEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['slug'] = $this->entity()->slug;
        $this->row['title'] = $this->entity()->title;
        $this->row['content'] = $this->entity()->content;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->slug = $this->row['slug'];
        $this->entity()->title = $this->row['title'];
        $this->entity()->content = $this->row['content'];
    }

}
