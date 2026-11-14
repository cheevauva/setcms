<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\DAO\EmailHasByIdDAO;
use Module\Email\DAO\EmailUpdateDAO;
use Module\Email\DAO\EmailCreateDAO;

class EmailSaveServant extends \UUA\Servant
{

    use \SetCMS\Entity\Traits\EntityCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (EmailHasByIdDAO::call($this, $this->entity->id)->isExists) {
            EmailUpdateDAO::call($this, $this->entity);
        } else {
            EmailCreateDAO::call($this, $this->entity);
        }
    }
}
