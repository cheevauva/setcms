<?php

declare(strict_types=1);

namespace Module\Email\DAO;

use Module\Email\Mapper\EmailToRowMapper;

class EmailUpdateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityCreateTrait;
    use \Module\Email\Traits\EmailDbalDAOTrait;
    use \Module\Email\Traits\EmailCallTrait;

    #[\Override]
    protected function row(): array
    {
        return EmailToRowMapper::call($this->container, $this->email)->row;
    }
}
