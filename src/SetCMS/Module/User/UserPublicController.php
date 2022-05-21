<?php

namespace SetCMS\Module\User;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\ServerRequestAttribute;
use SetCMS\Module\User\Servant\UserEntityRetrieveByAccessTokenServant;
use SetCMS\Module\User\Servant\UserRegistrationServant;
use SetCMS\Module\User\Scope\UserProfileScope;
use SetCMS\Module\User\Scope\UserInfoScope;
use SetCMS\Module\User\Scope\UserRegistrationScope;
use SetCMS\Module\User\Scope\UserDoRegistrationScope;

class UserPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function profile(ServerRequestInterface $request, UserProfileScope $scope, UserEntityRetrieveByAccessTokenServant $servant): UserProfileScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'token' => $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN),
        ]);
    }

    public function userinfo(ServerRequestInterface $request, UserInfoScope $scope, UserEntityRetrieveByAccessTokenServant $servant): UserInfoScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'token' => $request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN),
        ]);
    }

    public function registration(ServerRequestInterface $request, UserRegistrationScope $scope): UserRegistrationScope
    {
        $this->protectScopeByRequest($scope, $request);

        return $scope;
    }

    public function doRegistration(ServerRequestInterface $request, UserDoRegistrationScope $scope, UserRegistrationServant $servant): UserDoRegistrationScope
    {
        return $this->protectedServe($request, $servant, $scope, $request->getParsedBody());
    }

}
