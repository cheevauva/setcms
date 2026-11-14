<?php

declare(strict_types=1);

namespace Module\Email\DAO;

use Module\Email\Mapper\EmailToRowMapper;

class EmailUpdateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\Email\Traits\EmailDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return EmailToRowMapper::call($this, $this->entity)->row;
    }
}
