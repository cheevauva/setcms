<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;

class OAuthTokenEntityRetrieveByAccessTokenDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{
    use OAuthTokenEntityDbDAOTrait;

    public string $accessToken;
    
    public ?OAuthTokenEntity $oauthToken = null;
    
    public function serve(): void
    {
        $this->criteria = [
            'token' => $this->accessToken,
            'deleted' => 0,
        ];
        
        parent::serve();
        
        $this->oauthToken = $this->entity;
    }

}
