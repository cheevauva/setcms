<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO
{

    use OAuthClientEntityDbTrait;
    
    public ?OAuthClientEntity $oauthClient = null;
    
    public function serve(): void
    {
        parent::serve();
        
        $this->oauthClient = $this->entity;
    }
}
