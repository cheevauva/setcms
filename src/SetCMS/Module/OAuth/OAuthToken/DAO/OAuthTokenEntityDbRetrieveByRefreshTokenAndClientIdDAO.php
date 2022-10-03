<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

class OAuthTokenEntityDbRetrieveByRefreshTokenAndClientIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use OAuthTokenEntityDbDAOTrait;

    public string $refreshToken;
    public string $clientId;

}
