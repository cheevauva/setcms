<?php

namespace SetCMS\Module\User;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\ServerRequestAttribute;
use SetCMS\Module\User\Servant\UserEntityRetrieveByOAuthAccessTokenServant;
use SetCMS\Module\User\Servant\UserRegistrationServant;
use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\Scope\UserProfileScope;
use SetCMS\Module\User\Scope\UserInfoScope;
use SetCMS\Module\User\Scope\UserRegistrationScope;
use SetCMS\Module\User\Scope\UserDoRegistrationScope;
use SetCMS\Module\User\Scope\UserPublicLoginScope;
use SetCMS\Module\User\Scope\UserPublicDoLoginScope;

class UserPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function login(ServerRequestInterface $request, UserPublicLoginScope $scope): UserPublicLoginScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function doLogin(ServerRequestInterface $request, UserPublicDoLoginScope $scope, UserLoginServant $servant): UserPublicDoLoginScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function profile(ServerRequestInterface $request, UserProfileScope $scope): UserProfileScope
    {
        return $this->secureByScope($scope, $request);
    }

    public function userinfo(ServerRequestInterface $request, UserInfoScope $scope): UserInfoScope
    {
        return $this->secureByScope($scope, $request);
    }

    public function registration(ServerRequestInterface $request, UserRegistrationScope $scope): UserRegistrationScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function doRegistration(ServerRequestInterface $request, UserDoRegistrationScope $scope, UserRegistrationServant $servant): UserDoRegistrationScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

}
