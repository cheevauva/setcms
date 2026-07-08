<?php

declare(strict_types=1);

namespace Module\RAD01\Mapper;

use Module\RAD01\Entity\RAD01Entity;

class RAD01FromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) RAD01Entity $rad01;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('rad01')->notEmpty()->validate();

        $this->rad01 = new RAD01Entity();
        $this->rad01->id = $body->uuid('rad01.id')->val();
        $this->rad01->field01 = $body->string('rad01.field01')->notEmpty()->val();
    }
}
