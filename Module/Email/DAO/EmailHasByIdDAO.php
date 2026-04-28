<?php

declare(strict_types=1);

namespace Module\Email\DAO;

class EmailHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityHasByIdTrait;
    use \Module\Email\Traits\EmailDbalDAOTrait;
}
