<?php

declare(strict_types=1);

namespace Module\RAD01\Mapper;

use Module\RAD01\Entity\RAD01Entity;

class RAD01FromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) RAD01Entity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->entity = new RAD01Entity();
        $this->entity->id = $body->uuid('entity.id')->val();
        $this->entity->field01 = $body->string('entity.field01')->notEmpty()->val();
    }
}
