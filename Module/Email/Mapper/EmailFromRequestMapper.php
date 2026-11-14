<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use Module\Email\Entity\EmailEntity;

class EmailFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) EmailEntity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->entity = new EmailEntity();
        $this->entity->id = $body->uuid('entity.id')->val();
        $this->entity->subject = $body->string('entity.subject')->notEmpty()->val();
    }
}
