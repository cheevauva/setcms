<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;

class PageFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) PageEntity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->entity = new PageEntity();
        $this->entity->id = $body->uuid('entity.id')->val();
        $this->entity->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->entity->title = $body->string('entity.title')->notEmpty()->val();
        $this->entity->content = $body->string('entity.content')->notEmpty()->val();
    }
}
