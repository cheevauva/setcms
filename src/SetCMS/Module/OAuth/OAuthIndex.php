<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelDoAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelLogin;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorizeCode;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelCallback;
use SetCMS\Module\OAuth\OAuthModel\OAuthModel;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelToken;
use SetCMS\Module\OAuth\OAuthService;
use SetCMS\RequestAttribute;
use SetCMS\Module\Captcha\CaptchaService;

final class OAuthIndex
{

    private OAuthService $oauthService;
    private CaptchaService $captchaService;

    public function __construct(CaptchaService $captchaService, OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
        $this->captchaService = $captchaService;
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
    public function doAuthorize(ServerRequestInterface $request, OAuthModelDoAuthorize $model): OAuthModelDoAuthorize
    {
        $model->fromArray($request->getParsedBody());

        if (!$model->isValid()) {
            return $model;
        }
        try {
            $this->captchaService->useSolvedCaptchaById($model->captcha);
            $this->oauthService->authorize($model);
        } catch (\Exception $ex) {
            $model->addMessage($ex instanceof NotFound ? 'Код не действителен, обновите картинку и введите код' : $ex->getMessage(), 'captcha');
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
        $token = $request->getAttribute(RequestAttribute::ACCESS_TOKEN);

        if (empty($token) || $token === 'guest') {
            return $model;
        }

        try {
            $this->oauthService->removeToken($token);
        } catch (\Exception $ex) {
            return $model;
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
        $params['cms_token'] = $request->getAttribute(RequestAttribute::ACCESS_TOKEN);
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
    public function login(ServerRequestInterface $request, OAuthModelLogin $model): OAuthModelLogin
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

        if ($model->isValid()) {
            $this->oauthService->checkThePossibilityOfAuthorization($model);
        }

        return $model;
    }

}
