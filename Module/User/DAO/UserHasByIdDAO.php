<?php

declare(strict_types=1);

namespace Module\User\DAO;

class UserHasByIdDAO extends \SetCMS\Entity\DAO\EntityHasByIdDAO
{

    use \Module\User\Traits\UserDbalTrait;
}
