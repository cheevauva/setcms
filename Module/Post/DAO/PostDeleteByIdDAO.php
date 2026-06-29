<?php

declare(strict_types=1);

namespace Module\Post\DAO;

class PostDeleteByIdDAO extends \SetCMS\Entity\DAO\EntityDeleteByIdDAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;
}
