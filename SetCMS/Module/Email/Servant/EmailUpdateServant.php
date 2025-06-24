<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Servant;

use SetCMS\Module\Email\Entity\EmailEntity;
use SetCMS\Module\Email\DAO\EmailHasByIdDAO;
use SetCMS\Module\Email\DAO\EmailSaveDAO;
use SetCMS\Module\Email\Exception\EmailNotFoundException;

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
