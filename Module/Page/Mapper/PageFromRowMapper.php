<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageMapperNotFoundKeyInRowException;

class PageFromRowMapper extends \Module\Basic\Mapper\BasicEntityFromRowMapper 
{

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $this->page = new PageEntity();
        $this->page->slug = $this->string('slug');
        $this->page->title = $this->string('title');
        $this->page->content = $this->string('content');
        $this->id($this->page);
        $this->basic($this->page);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): PageMapperNotFoundKeyInRowException
    {
        return new PageMapperNotFoundKeyInRowException($key);
    }
}
