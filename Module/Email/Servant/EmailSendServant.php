<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailSaveDAO;

class EmailSendServant extends \UUA\Servant
{

    public bool $immediate = false;
    public EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        $save = EmailSaveDAO::new($this->container);
        $save->email = $this->email;
        $save->serve();

        if ($this->immediate) {
            // отправка почты
        }
    }
}
