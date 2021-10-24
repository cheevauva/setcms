<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthClientService;
use SetCMS\Module\OAuth\OAuthClientModel\OAuthClientModelSave;
use SetCMS\Module\Ordinary\OrdinaryResourceController;

class OAuthClientResource
{

    use \SetCMS\Module\Ordinary\OrdinaryCRUD;

    public function __construct(OAuthClientService $service, OrdinaryResourceController $ordinary)
    {
        $this->ordinary($ordinary)->service($service);
    }

    public function create(ServerRequestInterface $request, OAuthClientModelSave $model): OAuthClientModelSave
    {
        return $this->ordinary()->save($request, $model);
    }

    public function update(ServerRequestInterface $request, OAuthClientModelSave $model): OAuthClientModelSave
    {
        return $this->ordinary()->save($request, $model);
    }

}
