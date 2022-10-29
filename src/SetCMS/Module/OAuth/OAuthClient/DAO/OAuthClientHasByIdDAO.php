<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

class OAuthClientHasByIdDAO extends \SetCMS\Entity\DAO\EntityDbHasByIdDAO
{

    use OAuthClientEntityDbDAOTrait;
}
