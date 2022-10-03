<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Mapper;

use SetCMS\Entity\Mapper\EntityDbMapper;
use SetCMS\Module\Page\PageEntity;

class PageEntityDbMapper extends EntityDbMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): PageEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['content'] = $this->entity()->content;
        $this->row['slug'] = $this->entity()->slug;
        $this->row['title'] = $this->entity()->title;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->content = $this->row['content'];
        $this->entity()->title = $this->row['title'];
        $this->entity()->slug = $this->row['slug'];
    }

}
