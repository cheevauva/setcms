<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

class TemplateToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowTrait;
    use \Module\Template\Traits\TemplateCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->row['template'] = $this->template->template;
        $this->row['title'] = $this->template->title;
        $this->row['slug'] = $this->template->slug;
        $this->mappingDefault($this->template);
    }
}
