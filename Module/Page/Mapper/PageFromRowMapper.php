<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use SetCMS\Mapper\EntityFromRowMapper;
use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageMapperNotFoundKeyInRowException;

/**
 * @extends EntityFromRowMapper<PageEntity>
 */
class PageFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    public function serve(): void
    {
        parent::serve();
        
        $page = PageEntity::as($this->entity);
        $page->slug = strval($this->row['slug'] ?? throw new PageMapperNotFoundKeyInRowException('slug'));
        $page->title = strval($this->row['title'] ?? throw new PageMapperNotFoundKeyInRowException('title'));
        $page->content = strval($this->row['content'] ?? throw new PageMapperNotFoundKeyInRowException('content'));
    }
}
