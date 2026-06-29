<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

class PageToRowMapper extends \SetCMS\Entity\Mapper\EntityBasicToRowMapper
{

    use \Module\Page\Traits\PageCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->page);
        $this->basic($this->page);
        $this->row['slug'] = $this->page->slug;
        $this->row['title'] = $this->page->title;
        $this->row['content'] = $this->page->content;
    }
}
