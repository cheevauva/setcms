<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\DAO;

use SetCMS\Module\OAuth\OAuthApp\OAuthAppEntity;

class OAuthAppEntityRetrieveByClientIdDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use OAuthAppEntityDbDAOTrait;

    public ?OAuthAppEntity $oauthApp = null;
    public string $clientId;

    public function serve(): void
    {
        $this->criteria = [
            'deleted' => 0,
            'client_id' => $this->clientId,
        ];

        parent::serve();

        $this->oauthApp = $this->entity;
    }

}
