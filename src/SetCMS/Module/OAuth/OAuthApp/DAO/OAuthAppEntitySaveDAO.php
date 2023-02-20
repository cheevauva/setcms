<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\DAO;

use SetCMS\Entity\DAO\EntitySaveDAO;

class OAuthAppEntitySaveDAO extends EntitySaveDAO
{

    use OAuthAppEntityDbDAOTrait;
}
