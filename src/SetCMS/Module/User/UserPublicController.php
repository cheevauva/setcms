<?php

namespace SetCMS\Module\User;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Contract\Factory;
use SetCMS\Module\User\Servant\UserRegistrationServant;
use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\Scope\UserPublicProfileScope;
use SetCMS\Module\User\Scope\UserInfoScope;
use SetCMS\Module\User\Scope\UserRegistrationScope;
use SetCMS\Module\User\Scope\UserDoRegistrationScope;
use SetCMS\Module\User\Scope\UserPublicLoginScope;
use SetCMS\Module\User\Scope\UserPublicDoLoginScope;
use SetCMS\Module\User\Scope\UserPublicLogoutScope;
use SetCMS\Module\UserSession\Servant\UserSessionCreateByUserServant;
use SetCMS\Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use SetCMS\RequestAttribute;

class UserPublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function login(ServerRequestInterface $request, UserPublicLoginScope $scope): UserPublicLoginScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function logout(ServerRequestInterface $request, UserPublicLogoutScope $scope, UserSessionDeleteByIdDAO $servant): UserPublicLogoutScope
    {
        $this->serve($request, $servant, $scope, [
            'token' => $request->getCookieParams()[RequestAttribute::accessToken->toString()],
        ]);

        return $scope;
    }

    public function doLogin(ServerRequestInterface $request, UserPublicDoLoginScope $scope, Factory $factory): UserPublicDoLoginScope
    {
        $scope->device = strval($request->getHeaderLine('user-agent'));

        return $this->multiserve($request, [
            UserLoginServant::make($factory),
            UserSessionCreateByUserServant::make($factory),
        ], $scope, $request->getParsedBody());
    }

    public function profile(ServerRequestInterface $request, UserPublicProfileScope $scope): UserPublicProfileScope
    {
        $this->secureByScope($scope, $request);

        $scope->from(RequestAttribute::currentUser->fromRequest($request));

        return $scope;
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
