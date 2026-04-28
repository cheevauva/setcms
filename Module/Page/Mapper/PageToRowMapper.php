<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

class PageToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowBasicTrait;
    use \Module\Page\Traits\PageCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->page);
        $this->mappingBasic($this->page);
        $this->row['slug'] = $this->page->slug;
        $this->row['title'] = $this->page->title;
        $this->row['content'] = $this->page->content;
    }
}
