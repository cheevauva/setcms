<?php

namespace SetCMS\Module\User;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\User\Servant\UserRegistrationServant;
use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\Scope\UserPublicProfileScope;
use SetCMS\Module\User\Scope\UserInfoScope;
use SetCMS\Module\User\Scope\UserPublicRegistrationScope;
use SetCMS\Module\User\Scope\UserPublicDoRegistrationScope;
use SetCMS\Module\User\Scope\UserPublicLoginScope;
use SetCMS\Module\User\Scope\UserPublicDoLoginScope;
use SetCMS\Module\User\Scope\UserPublicLogoutScope;
use SetCMS\Module\UserSession\Servant\UserSessionCreateByUserServant;
use SetCMS\Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;

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
        return $this->serve($request, $servant, $scope);
    }

    public function doLogin(ServerRequestInterface $request, UserPublicDoLoginScope $scope): UserPublicDoLoginScope
    {
        return $this->multiserve($request, [
            CaptchaUseResolvedCaptchaServant::class,
            UserLoginServant::class,
            UserSessionCreateByUserServant::class,
        ], $scope);
    }

    public function profile(ServerRequestInterface $request, UserPublicProfileScope $scope): UserPublicProfileScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function userinfo(ServerRequestInterface $request, UserInfoScope $scope): UserInfoScope
    {
        return $this->secureByScope($scope, $request);
    }

    public function registration(ServerRequestInterface $request, UserPublicRegistrationScope $scope): UserPublicRegistrationScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function doRegistration(ServerRequestInterface $request, UserPublicDoRegistrationScope $scope, UserRegistrationServant $servant): UserPublicDoRegistrationScope
    {
        return $this->serve($request, $servant, $scope);
    }

}
