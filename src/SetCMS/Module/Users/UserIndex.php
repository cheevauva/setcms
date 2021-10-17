<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\UserModel\UserModelLogin;
use SetCMS\Module\Users\UserModel\UserModelRegistration;
use SetCMS\Module\Users\User;
use SetCMS\Module\OAuth\OAuthService;

final class UserIndex
{

    private UserService $service;
    private OAuthService $oauthService;

    public function __construct(UserService $userService, OAuthService $oauthService)
    {
        $this->service = $userService;
        $this->oauthService = $oauthService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function profile(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $model->id = $request->getAttribute('id');

        if ($model->isValid()) {
            $this->service->read($model);
        }

        return $model;
    }
    
    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-need-not-auth
     */
    public function registration(UserModelRegistration $model): UserModelRegistration
    {
        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-need-not-auth
     */
    public function doRegistration(ServerRequestInterface $request, UserModelRegistration $model): UserModelRegistration
    {
        $model->fromArray($request->getParsedBody());

        if ($model->isValid()) {
            $this->service->registation($model);
        }

        return $model;
    }

}
