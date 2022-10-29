<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthCode\DAO;

use SetCMS\Module\OAuth\OAuthCode\OAuthCodeEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthCodeEntityRetrieveByCodeAndClientIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use OAuthCodeEntityDbDAOTrait;

    public string $code;
    public OAuthClientEntity $oauthClient;
    public ?OAuthCodeEntity $oauthCode = null;

    public function serve(): void
    {
        $this->criteria = [
            'code' => $this->code,
            'client_id' => (string) $this->oauthClient->id,
        ];

        parent::serve();

        $this->oauthCode = $this->entity;
    }

}
