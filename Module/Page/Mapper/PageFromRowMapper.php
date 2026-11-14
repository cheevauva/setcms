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
        $entity = $this->entity = new PageEntity();
        $entity->slug = $this->string('slug');
        $entity->title = $this->string('title');
        $entity->content = $this->string('content');

        parent::run();
    }
}
