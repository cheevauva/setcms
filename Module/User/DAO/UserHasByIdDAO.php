<?php

declare(strict_types=1);

namespace Module\User\DAO;

class UserHasByIdDAO extends \UUA\DAO
{

    use \Module\User\Traits\UserDbalTrait;
    use \SetCMS\DAO\DAOEntityHasByIdTrait;
}
