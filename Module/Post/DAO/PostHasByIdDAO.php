<?php

declare(strict_types=1);

namespace Module\Post\DAO;

class PostHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityHasByIdTrait;
    use \Module\Post\Traits\PostDbalDAOTrait;
}
