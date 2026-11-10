<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\Servant\EmailSaveServant;

class EmailSendServant extends \UUA\Servant
{

    use \Module\Email\Traits\EmailCallTrait;

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
