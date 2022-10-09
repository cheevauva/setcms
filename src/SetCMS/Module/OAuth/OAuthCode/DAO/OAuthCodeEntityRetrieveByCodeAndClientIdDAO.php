<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthCode\DAO;

use SetCMS\Module\OAuth\OAuthCode\OAuthCodeEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\UUID;

class OAuthCodeEntityRetrieveByCodeAndClientIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use OAuthCodeEntityDbDAOTrait;

    public string $code;
    public UUID $oauthClientId;
    public ?OAuthClientEntity $oauthClient;
    public ?OAuthCodeEntity $oauthCode;

    public function serve(): void
    {
        if (!empty($this->oauthClient)) {
            $this->oauthClientId = $this->oauthClient->id;
        }

        $this->criteria = [
            'code' => $this->code,
            'client_id' => (string) $this->oauthClientId,
        ];

        parent::serve();

        $this->oauthCode = $this->entity;
    }

}
