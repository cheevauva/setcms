<?php

declare(strict_types=1);

namespace Module\Post\DAO;

class PostHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityHasByIdDAOTrait;
    use \Module\Post\Traits\PostDbalDAOTrait;
}
