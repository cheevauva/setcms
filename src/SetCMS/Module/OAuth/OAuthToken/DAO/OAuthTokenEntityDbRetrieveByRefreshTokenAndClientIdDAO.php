<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

class OAuthTokenEntityDbRetrieveByRefreshTokenAndClientIdDAO extends \SetCMS\Core\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use OAuthTokenEntityDbTrait;

    public string $refreshToken;
    public string $clientId;

}
