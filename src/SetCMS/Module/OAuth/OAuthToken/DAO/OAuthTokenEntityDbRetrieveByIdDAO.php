<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;

class OAuthTokenEntityDbRetrieveByIdDAO extends \SetCMS\Core\Entity\DAO\EntityDbRetrieveByIdDAO
{

    use \SetCMS\FactoryTrait;

    public ?OAuthTokenEntity $oauthToken = null;
    
    public function serve(): void
    {
        parent::serve();
        
        $this->oauthToken = $this->entity;
    }

}
