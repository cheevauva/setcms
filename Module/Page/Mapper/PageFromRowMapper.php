<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageMapperNotFoundKeyInRowException;

class PageFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\EntityFromRowMapperTrait;
    use \SetCMS\Mapper\EntityFromRowBasicMapperTrait;

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $this->page = PageEntity::as($this->newEntityByRow($this->row));
        $this->page->slug = strval($this->row['slug'] ?? throw $this->notFoundKeyInRowException('slug'));
        $this->page->title = strval($this->row['title'] ?? throw $this->notFoundKeyInRowException('title'));
        $this->page->content = strval($this->row['content'] ?? throw $this->notFoundKeyInRowException('content'));
        
        $this->mapperBasic($this->row, $this->page);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new PageMapperNotFoundKeyInRowException($key);
    }
}
