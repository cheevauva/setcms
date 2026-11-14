<?php

declare(strict_types=1);

namespace Module\RAD99\Mapper;

use Module\RAD99\Entity\RAD99Entity;

class RAD99FromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) RAD99Entity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->entity = new RAD99Entity();
        $this->entity->id = $body->uuid('entity.id')->val();
        $this->entity->field99 = $body->string('entity.field99')->notEmpty()->val();
    }
}
