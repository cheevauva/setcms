<?php

declare(strict_types=1);

namespace Module\Email\DAO;

class EmailHasByIdDAO extends \SetCMS\Entity\DAO\EntityHasByIdDAO
{

    use \Module\Email\Traits\EmailDbalDAOTrait;
}
