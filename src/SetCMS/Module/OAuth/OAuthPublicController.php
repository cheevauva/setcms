<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelDoAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelLogin;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorizeCode;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelCallback;
use SetCMS\ServerRequestAttribute;
use SetCMS\Module\OAuth\OAuthToken\Form\OAuthTokenLogoutScope;
use SetCMS\Module\OAuth\OAuthToken\Form\OAuthTokenForm;

final class OAuthPublicController
{

    use \SetCMS\Controller\ControllerTrait;

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-wrapper-json-none
     * @setcms-csrf-protect-disabled
     */
    public function token(ServerRequestInterface $request, OAuthTokenForm $form): OAuthTokenForm
    {
        return $this->serve($servant, $form, $request->getParsedBody());

        $form->fromArray();


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

        if ($model->valid()) {
            $this->oauthService->authorizationCode($model);
        }

        return $model;
    }

    public function logout(ServerRequestInterface $request, OAuthTokenLogoutScope $scope, $servant): OAuthTokenLogoutScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'token' => $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN),
        ]);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-json
     * @setcms-response-content-http-headers
     */
    public function callback(ServerRequestInterface $request, OAuthModelCallback $model): OAuthModelCallback
    {
        $params = $request->getQueryParams();
        $params['cms_token'] = $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN);
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
