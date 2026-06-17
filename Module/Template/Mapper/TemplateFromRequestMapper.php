<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use Module\Template\Entity\TemplateEntity;

class TemplateFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public protected(set) TemplateEntity $template;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('template')->notEmpty()->validate();

        $this->template = new TemplateEntity();
        $this->template->id = $body->uuid('template.id')->val();
        $this->template->template = $body->string('template.template')->notEmpty()->val();
        $this->template->slug = $body->string('template.slug')->notEmpty()->val();
        $this->template->title = $body->string('template.title')->notEmpty()->val();
    }
}
