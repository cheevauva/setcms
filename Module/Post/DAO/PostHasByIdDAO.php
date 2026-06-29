<?php

declare(strict_types=1);

namespace Module\Post\DAO;

class PostHasByIdDAO extends \SetCMS\Entity\DAO\EntityHasByIdDAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;
}
