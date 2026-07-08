<?php

declare(strict_types=1);

namespace Module\RAD99\Mapper;

use Module\RAD99\Entity\RAD99Entity;

class RAD99FromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) RAD99Entity $rad99;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('rad99')->notEmpty()->validate();

        $this->rad99 = new RAD99Entity();
        $this->rad99->id = $body->uuid('rad99.id')->val();
        $this->rad99->field99 = $body->string('rad99.field99')->notEmpty()->val();
    }
}
