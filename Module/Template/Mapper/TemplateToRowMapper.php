<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use SetCMS\Entity\Mapper\EntityToRowMapper;
use Module\Template\Entity\TemplateEntity;

class TemplateToRowMapper extends EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $template = TemplateEntity::as($this->entity);

        $this->row['template'] = $template->template;
        $this->row['title'] = $template->title;
        $this->row['slug'] = $template->slug;

        parent::run();
    }
}
