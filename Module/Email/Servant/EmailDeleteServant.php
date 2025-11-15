<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use SetCMS\UUID;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use Module\Email\DAO\EmailSaveDAO;
use Module\Email\Exception\EmailNotFoundException;

class EmailDeleteServant extends \UUA\Servant
{

    public ?EmailEntity $email = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $emailById = EmailRetrieveManyByCriteriaDAO::new($this->container);
        $emailById->id = $this->id ?? ($this->email->id ?? throw new \RuntimeException('id is undefined'));
        $emailById->serve();

        if (!$emailById->email) {
            throw new EmailNotFoundException;
        }

        $email = EmailEntity::as($emailById->email);
        $email->deleted = true;

        $save = EmailSaveDAO::new($this->container);
        $save->email = $email;
        $save->serve();

        $this->email = $email;
    }
}
