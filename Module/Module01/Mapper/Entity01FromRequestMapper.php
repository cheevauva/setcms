<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

use Module\Module01\Entity\Entity01Entity;

class Entity01FromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public protected(set) Entity01Entity $entity01;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('entity01')->notEmpty()->validate();

        $this->entity01 = new Entity01Entity();
        $this->entity01->id = $body->uuid('entity01.id')->val();
        $this->entity01->field01 = $body->string('entity01.field01')->notEmpty()->val();
    }
}
