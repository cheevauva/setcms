<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorizeCode;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelCallback;
use SetCMS\Module\OAuth\OAuthModel\OAuthModel;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelToken;
use SetCMS\Module\OAuth\OAuthClientService;
use SetCMS\Module\OAuth\OAuthService;

final class OAuthIndex
{

    private OAuthService $oauthService;

    public function __construct(OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-wrapper-json-none
     * @setcms-csrf-protect-disabled
     */
    public function token(ServerRequestInterface $request, OAuthModelToken $model): OAuthModel
    {
        $model->fromArray($request->getParsedBody());

        if (!$model->isValid()) {
            return $model;
        }


        $oauthModel = $model->getOAuthModel();
        $oauthModel->fromArray($request->getParsedBody());

        if (!$oauthModel->isValid()) {
            return $oauthModel;
        }

        if ($model->isGrantTypePassword()) {
            $this->oauthService->tokenByPassword($oauthModel);
        }

        if ($model->isGrantTypeRefreshToken()) {
            $this->oauthService->refreshToken($oauthModel);
        }

        if ($model->isGrantTypeAuthorizationCode()) {
            $this->oauthService->tokenByAuthorizationCode($oauthModel);
        }

        return $oauthModel;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function doAuthorize(ServerRequestInterface $request, OAuthModelAuthorize $model): OAuthModelAuthorize
    {
        $model->fromArray($request->getParsedBody());

        if ($model->isValid()) {
            $this->oauthService->authorize($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-wrapper-json-none
     */
    public function code(ServerRequestInterface $request, OAuthModelAuthorizeCode $model): OAuthModelAuthorizeCode
    {
        $model->fromArray($request->getQueryParams());

        if ($model->isValid()) {
            $this->oauthService->authorizationCode($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     * @setcms-response-with-headers
     */
    public function logout(ServerRequestInterface $request, OAuthModelCallback $model): OAuthModelCallback
    {
        $tokens = $this->oauthService->parseTokens(array_filter([
            $request->getHeader('Authorization')[0] ?? null,
            $request->getCookieParams()['Authorization'] ?? null,
        ]));

        if ($tokens) {
            $token = reset($tokens);
            $this->oauthService->removeToken($token);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     * @setcms-response-with-headers
     */
    public function callback(ServerRequestInterface $request, OAuthModelCallback $model): OAuthModelCallback
    {
        $params = $request->getQueryParams();
        $params['client_id'] = $request->getAttribute('id');
        
        $model->fromArray($params);

        if ($model->isValid()) {
            $this->oauthService->callback($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function login(ServerRequestInterface $request, OAuthModelAuthorize $model): OAuthModelAuthorize
    {
        $model->fromArray($request->getQueryParams());
        $model->isValid();

        $model->oauthClients($this->oauthService->getClientsWithEnabledAuthorization());

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function authorize(ServerRequestInterface $request, OAuthModelAuthorize $model): OAuthModelAuthorize
    {
        $model->fromArray($request->getQueryParams());
        $model->isValid();

        return $model;
    }

}
