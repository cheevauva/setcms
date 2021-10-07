<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\UserModel\UserModelLogin;
use SetCMS\Module\Users\UserModel\UserModelRegistration;
use SetCMS\Module\Users\User;

class UserIndex
{

    private UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->service->list($model->fromArray($request->getQueryParams()));
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function login(ServerRequestInterface $request, UserModelLogin $model): UserModelLogin
    {
        $model->fromArray($request->getQueryParams());
        $model->entity(new User);
        
        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-access-level-index
     */
    public function doLogin(ServerRequestInterface $request, UserModelLogin $model): UserModelLogin
    {
        $model->fromArray($request->getParsedBody());

        $this->service->login($model);

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function registration(UserModelRegistration $model): UserModelRegistration
    {
        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-access-level-index
     */
    public function doRegistation(ServerRequestInterface $request, UserModelRegistration $model): UserModelRegistration
    {
        $model->fromArray($request->getParsedBody());

        $this->service->registation($model);

        return $model;
    }

}
