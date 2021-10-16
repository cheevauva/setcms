<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModel;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelToken;
use SetCMS\Module\OAuth\OAuthService;

final class OAuthIndex
{

    private OAuthService $oauthService;

    public function __construct(OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     * @setcms-wrapper-json-none
     */
    public function token(ServerRequestInterface $request, OAuthModelToken $model): OAuthModel
    {
        $model->fromArray($request->getQueryParams());

        if (!$model->isValid()) {
            return $model;
        }


        $oauthModel = $model->getOAuthModel();
        $oauthModel->fromArray($request->getQueryParams());

        if (!$oauthModel->isValid()) {
            return $oauthModel;
        }
        
        if ($model->isGrantTypePassword()) {
            $this->oauthService->tokenByPassword($oauthModel);
        }
        
        if ($model->isGrantTypeRefreshToken()) {
            $this->oauthService->refreshToken($oauthModel);
        }
        
        return $oauthModel;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     * @setcms-wrapper-json-none
     */
    public function authorize(ServerRequestInterface $request, OAuthModelAuthorize $model): OAuthModelAuthorize
    {
        $model->fromArray($request->getQueryParams());

        if ($model->isValid()) {
            $this->oauthService->authorize($model);
        }

        return $model;
    }

}
