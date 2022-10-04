<?php

namespace SetCMS\Module\OAuth;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\Scope\OAuthAuthorizeScope;
use SetCMS\Module\OAuth\Scope\OAuthDoAuthorizeScope;
use SetCMS\Module\OAuth\Scope\OAuthLoginScope;
use SetCMS\Module\OAuth\Scope\OAuthCallbackScope;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorizeCode;
use SetCMS\ServerRequestAttribute;
use SetCMS\Module\OAuth\OAuthToken\Form\OAuthTokenLogoutScope;
use SetCMS\Module\OAuth\OAuthToken\Form\OAuthTokenForm;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveManyDAO;
use SetCMS\Module\OAuth\Servant\OAuthCheckThePossibilityOfAuthorizationServant;
use SetCMS\Module\OAuth\Servant\OAuthAuthorizeWithCaptchaServant;
use SetCMS\Module\OAuth\Servant\OAuthCallbackServant;

final class OAuthPublicController
{

    use \SetCMS\Controller\ControllerTrait;

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

    public function callback(ServerRequestInterface $request, OAuthCallbackServant $servant, OAuthCallbackScope $scope): OAuthCallbackScope
    {
        $params = $request->getQueryParams();
        $params['cms_token'] = $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN);
        $params['client_id'] = $params['client_id'] ?? $request->getAttribute('id');

        return $this->protectedServe($request, $servant, $scope, $params);
    }

    public function login(ServerRequestInterface $request, OAuthClientEntityRetrieveManyDAO $servant, OAuthLoginScope $scope): OAuthLoginScope
    {
        return $this->protectedServe($request, $servant, $scope, $request->getQueryParams());
    }

    public function authorize(ServerRequestInterface $request, OAuthCheckThePossibilityOfAuthorizationServant $servant, OAuthAuthorizeScope $scope): OAuthAuthorizeScope
    {
        return $this->protectedServe($request, $servant, $scope, $request->getQueryParams());
    }

    public function doAuthorize(ServerRequestInterface $request, OAuthAuthorizeWithCaptchaServant $servant, OAuthDoAuthorizeScope $scope): OAuthDoAuthorizeScope
    {
        return $this->protectedServe($request, $servant, $scope, $request->getParsedBody());
    }

}
