<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientDAO;
use SetCMS\Module\OAuth\OAuthClient;

class OAuthClientService extends \SetCMS\Module\Ordinary\OrdinaryService
{

    private OAuthClientDAO $oauthClientDAO;
    
    public function __construct(OAuthClientDAO $oauthClientDAO)
    {
        $this->oauthClientDAO = $oauthClientDAO;
    }

    protected function dao(): OAuthClientDAO
    {
        return $this->oauthClientDAO;
    }

    public function entity(): OAuthClient
    {
        return new OAuthClient;
    }

}
