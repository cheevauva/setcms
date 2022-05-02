<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Core\Entity\DAO\EntityDbSaveDAO;

class PostEntityDbSaveDAO extends EntityDbSaveDAO
{

    use PostEntityDbTrait;
}
