<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use Module\Post\Entity\PostEntity;

class PostFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) PostEntity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->entity = new PostEntity();
        $this->entity->id = $body->uuid('entity.id')->val();
        $this->entity->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->entity->title = $body->string('entity.title')->notEmpty()->val();
        $this->entity->message = $body->string('entity.message')->notEmpty()->val();
    }
}
