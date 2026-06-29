<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use Module\Email\Entity\EmailEntity;

class EmailFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('email')->notEmpty()->validate();

        $this->email = new EmailEntity();
        $this->email->id = $body->uuid('email.id')->val();
        $this->email->subject = $body->string('email.subject')->notEmpty()->val();
    }
}
