<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\DAO\EmailHasByIdDAO;
use Module\Email\DAO\EmailUpdateDAO;
use Module\Email\DAO\EmailCreateDAO;

class EmailSaveServant extends \UUA\Servant
{

    use \Module\Email\Traits\EmailCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (EmailHasByIdDAO::call($this, $this->email->id)->isExists) {
            EmailUpdateDAO::call($this, $this->email);
        } else {
            EmailCreateDAO::call($this, $this->email);
        }
    }
}
