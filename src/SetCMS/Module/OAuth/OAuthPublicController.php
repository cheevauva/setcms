<?php

namespace SetCMS\Module\OAuth;

use SetCMS\ServerRequestAttribute;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\Scope\OAuthAuthorizeScope;
use SetCMS\Module\OAuth\Scope\OAuthDoAuthorizeScope;
use SetCMS\Module\OAuth\Scope\OAuthLoginScope;
use SetCMS\Module\OAuth\Scope\OAuthCallbackScope;
use SetCMS\Module\OAuth\Scope\OAuthAuthorizeCodeScope;
use SetCMS\Module\OAuth\Scope\OAuthLogoutScope;
use SetCMS\Module\OAuth\OAuthToken\Form\OAuthTokenForm;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveManyDAO;
use SetCMS\Module\OAuth\Servant\OAuthCheckThePossibilityOfAuthorizationServant;
use SetCMS\Module\OAuth\Servant\OAuthAuthorizeWithCaptchaServant;
use SetCMS\Module\OAuth\Servant\OAuthCallbackServant;
use SetCMS\Module\OAuth\Servant\OAuthLogoutByTokenServant;

final class OAuthPublicController
{

    use \SetCMS\Controller\ControllerTrait;

    public function token(ServerRequestInterface $request, OAuthTokenForm $form): OAuthTokenForm
    {
        return $this->directServe($servant, $form, $request->getParsedBody());

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

    public function code(ServerRequestInterface $request, OAuthAuthorizeCodeScope $scope): OAuthAuthorizeCodeScope
    {
        return $this->serve($request, $servant, $scope, $request->getQueryParams());
    }

    public function logout(ServerRequestInterface $request, OAuthLogoutScope $scope, OAuthLogoutByTokenServant $servant): OAuthLogoutScope
    {
        return $this->serve($request, $servant, $scope, [
            'token' => $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN),
        ]);
    }

    public function callback(ServerRequestInterface $request, OAuthCallbackServant $servant, OAuthCallbackScope $scope): OAuthCallbackScope
    {
        $params = $request->getQueryParams();
        $params['cms_token'] = $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN);
        $params['client_id'] = $params['client_id'] ?? $request->getAttribute('id');

        return $this->serve($request, $servant, $scope, $params);
    }

    public function login(ServerRequestInterface $request, OAuthClientEntityRetrieveManyDAO $servant, OAuthLoginScope $scope): OAuthLoginScope
    {
        return $this->serve($request, $servant, $scope, $request->getQueryParams());
    }

    public function authorize(ServerRequestInterface $request, OAuthCheckThePossibilityOfAuthorizationServant $servant, OAuthAuthorizeScope $scope): OAuthAuthorizeScope
    {
        return $this->serve($request, $servant, $scope, $request->getQueryParams());
    }

    public function doAuthorize(ServerRequestInterface $request, OAuthAuthorizeWithCaptchaServant $servant, OAuthDoAuthorizeScope $scope): OAuthDoAuthorizeScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

}
