<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientDAO;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\HttpStatusCode\NotFound;

class OAuthService
{

    private OAuthClientDAO $oauthClientDAO;

    public function __construct(OAuthClientDAO $oauthClientDAO)
    {
        $this->oauthClientDAO = $oauthClientDAO;
    }

    public function authorize(OAuthModelAuthorize $model): void
    {
        try {
            $client = $this->oauthClientDAO->getById($model->client_id);
        } catch (NotFound $ex) {
            $model->addMessage('client is not exists', 'invalid_client');
        }
    }

}
