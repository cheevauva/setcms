<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthAppToken\DAO;

use SetCMS\Module\OAuth\OAuthAppToken\OAuthAppTokenEntity;

class OAuthAppTokenEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO
{

    use OAuthAppTokenEntityDbDAOTrait;

    public ?OAuthAppTokenEntity $OAuthAppToken = null;
    
    public function serve(): void
    {
        parent::serve();
        
        $this->OAuthAppToken = $this->entity;
    }

}
