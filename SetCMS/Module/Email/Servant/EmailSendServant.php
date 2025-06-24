<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Servant;

use SetCMS\Module\Email\Entity\EmailEntity;
use SetCMS\Module\Email\DAO\EmailSaveDAO;

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
