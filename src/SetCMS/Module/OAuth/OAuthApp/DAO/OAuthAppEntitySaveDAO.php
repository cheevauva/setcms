<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\DAO;

use SetCMS\Entity\DAO\EntityDbSaveDAO;

class OAuthAppEntitySaveDAO extends EntityDbSaveDAO
{

    use OAuthAppEntityDbDAOTrait;
}
