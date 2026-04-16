<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageMapperNotFoundKeyInRowException;

class PageFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\EntityFromRowMapperTrait;

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $page = PageEntity::as($this->newEntityByRow($this->row));
        $page->slug = strval($this->row['slug'] ?? throw $this->notFoundKeyInRowException('slug'));
        $page->title = strval($this->row['title'] ?? throw $this->notFoundKeyInRowException('title'));
        $page->content = strval($this->row['content'] ?? throw $this->notFoundKeyInRowException('content'));

        $this->page = $page;
    }

    #[\Override]
    protected function notFoundKeyInRowException($key): \Throwable
    {
        return new PageMapperNotFoundKeyInRowException($key);
    }
}
