<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use Module\Template\Entity\TemplateEntity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<TemplateEntity>
 */
class TemplateFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $template = $this->entity = new TemplateEntity();
        $template->template = $this->string('template');
        $template->title = $this->string('title');
        $template->slug = $this->string('slug');

        parent::run();
    }
}
