<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\Servant\EmailSaveServant;

class EmailSendServant extends \UUA\Servant
{

    use \Module\Email\Traits\EmailCallTrait;

    public bool $immediate = false;

    #[\Override]
    public function serve(): void
    {
        EmailSaveServant::call($this->container, $this->email);

        if ($this->immediate) {
            // отправка почты
        }
    }
}
