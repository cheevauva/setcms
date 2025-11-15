<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailHasByIdDAO;
use Module\Email\DAO\EmailSaveDAO;
use Module\Email\Exception\EmailNotFoundException;

class EmailUpdateServant extends \UUA\Servant
{

    public EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        $hasById = EmailHasByIdDAO::new($this->container);
        $hasById->id = $this->email->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new EmailNotFoundException;
        }

        $saveEntity = EmailSaveDAO::new($this->container);
        $saveEntity->email = $this->email;
        $saveEntity->serve();
    }
}
