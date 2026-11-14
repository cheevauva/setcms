<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;
use Module\Basic\Mapper\BasicEntityFromRowMapper;

/**
 * @extends BasicEntityFromRowMapper<PageEntity>
 */
class PageFromRowMapper extends BasicEntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $page = $this->entity = new PageEntity();
        $page->slug = $this->string('slug');
        $page->title = $this->string('title');
        $page->content = $this->string('content');

        parent::run();
    }
}
