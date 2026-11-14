<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use Module\Template\Entity\TemplateEntity;

class TemplateFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) TemplateEntity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->entity = new TemplateEntity();
        $this->entity->id = $body->uuid('entity.id')->val();
        $this->entity->entity = $body->string('entity.entity')->notEmpty()->val();
        $this->entity->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->entity->title = $body->string('entity.title')->notEmpty()->val();
    }
}
