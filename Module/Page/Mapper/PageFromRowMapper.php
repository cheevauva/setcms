<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageMapperNotFoundKeyInRowException;

class PageFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowBasicTrait;

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $this->page = new PageEntity();
        $this->page->slug = $this->string('slug');
        $this->page->title = $this->string('title');
        $this->page->content = $this->string('content');

        $this->mappingDefault($this->page);
        $this->mappingBasic($this->page);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new PageMapperNotFoundKeyInRowException($key);
    }
}
