<?php

declare(strict_types=1);

namespace Module\Post\DAO;

class PostDeleteByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityDeleteByIdDAOTrait;
    use PostCommonDAO;
}
