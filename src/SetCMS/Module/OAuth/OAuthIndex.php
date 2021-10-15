<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
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
    public function token(ServerRequestInterface $request, OAuthModelToken $model): OAuthModelToken
    {
        $model->fromArray($request->getQueryParams());

        if ($model->isValid()) {
            
        }

        return $model;
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
