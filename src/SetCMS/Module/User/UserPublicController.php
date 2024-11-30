<?php

namespace SetCMS\Module\User;

use SetCMS\Attribute\Http\RequestMethod;
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

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Application\Router\RouterTrait;

    #[RequestMethod('GET')]
    public function login(UserPublicLoginScope $scope): UserPublicLoginScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function logout(UserPublicLogoutScope $scope, UserSessionDeleteByIdDAO $servant): UserPublicLogoutScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function doLogin(UserPublicDoLoginScope $scope): UserPublicDoLoginScope
    {
        return $this->multiserve([
            CaptchaUseResolvedCaptchaServant::class,
            UserLoginServant::class,
            UserSessionCreateByUserServant::class,
        ], $scope);
    }

    #[RequestMethod('GET')]
    public function profile(UserPublicProfileScope $scope): UserPublicProfileScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function userinfo(UserInfoScope $scope): UserInfoScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function registration(UserPublicRegistrationScope $scope): UserPublicRegistrationScope
    {
        return $scope;
    }

    #[RequestMethod('POST')]
    public function doRegistration(UserPublicDoRegistrationScope $scope): UserPublicDoRegistrationScope
    {
        return $this->multiserve([
            CaptchaUseResolvedCaptchaServant::class,
            UserRegistrationServant::class,
        ], $scope);
    }

}
