<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientEntityRetrieveByClientIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{
    
    public ?OAuthClientEntity $oauthClient = null;
    public string $clientId;

    use OAuthClientEntityDbDAOTrait;

    public function serve(): void
    {
        $this->criteria = [
            'deleted' => 0,
            'client_id' => $this->clientId,
        ];
        
        parent::serve();

        $this->oauthClient = $this->entity;
    }

}
