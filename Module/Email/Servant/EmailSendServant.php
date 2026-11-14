<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\Servant\EmailSaveServant;
use Module\Email\Entity\EmailEntity;

class EmailSendServant extends \UUA\Servant
{

    public EmailEntity $email;
    public bool $immediate = false;

    #[\Override]
    protected function run(): void
    {
        EmailSaveServant::call($this, $this->email);

        if ($this->immediate) {
            // отправка почты
        }
    }
}
