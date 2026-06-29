<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

class TemplateToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\Template\Traits\TemplateCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->template);
        $this->row['template'] = $this->template->template;
        $this->row['title'] = $this->template->title;
        $this->row['slug'] = $this->template->slug;
    }
}
