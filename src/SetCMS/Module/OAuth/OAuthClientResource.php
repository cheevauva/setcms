<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthClientService;
use SetCMS\Module\OAuth\OAuthClientModel\OAuthClientModelSave;

class OAuthClientResource
{

    use \SetCMS\Module\Ordinary\OrdinaryResourceTrait;

    private OAuthClientService $oauthClientService;

    public function __construct(OAuthClientService $oauthClientService)
    {
        $this->oauthClientService = $this->service($oauthClientService);
    }

    public function create(ServerRequestInterface $request, OAuthClientModelSave $model): OAuthClientModelSave
    {
        return $this->save($request, $model);
    }

    public function update(ServerRequestInterface $request, OAuthClientModelSave $model): OAuthClientModelSave
    {
        return $this->save($request, $model);
    }

}
