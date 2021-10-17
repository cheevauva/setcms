<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\OAuth\OAuthClientModel\OAuthClientModelSave;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Ordinary\OrdinaryController;
use Psr\Http\Message\ServerRequestInterface;

final class OAuthClientAdmin
{

    private OAuthClientService $oauthClientService;
    private OrdinaryController $ordinaryAdmin;

    public function __construct(OAuthClientService $oauthClientService, OrdinaryController $ordinaryAdmin)
    {
        $this->ordinaryAdmin = $ordinaryAdmin;
        $this->ordinaryAdmin->service($oauthClientService);

        $this->oauthClientService = $oauthClientService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->ordinaryAdmin->index($request, $model);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function saveform(ServerRequestInterface $request, OrdinaryModel $createModel, OrdinaryModelRead $editModel): OrdinaryModel
    {
        return $this->ordinaryAdmin->saveform($request, $request->getAttribute('id') ? $editModel : $createModel);
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function save(ServerRequestInterface $request, OAuthClientModelSave $model): OAuthClientModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

}
