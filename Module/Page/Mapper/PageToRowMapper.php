<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use SetCMS\Mapper\EntityToRowMapper;
use Module\Page\Entity\PageEntity;

/**
 * @extends EntityToRowMapper<PageEntity>
 */
class PageToRowMapper extends EntityToRowMapper
{

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $page = PageEntity::as($this->entity);

        $this->row['slug'] = $page->slug;
        $this->row['title'] = $page->title;
        $this->row['content'] = $page->content;
    }
}
