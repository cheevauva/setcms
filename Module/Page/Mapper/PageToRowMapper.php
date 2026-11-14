<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;

class PageToRowMapper extends \Module\Basic\Mapper\BasicEntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = PageEntity::as($this->entity);

        $this->row['slug'] = $entity->slug;
        $this->row['title'] = $entity->title;
        $this->row['content'] = $entity->content;

        parent::run();
    }
}
