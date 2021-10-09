<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Session;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\UserModel\UserModelLogin;
use SetCMS\Module\Users\UserModel\UserModelRegistration;
use SetCMS\Module\Users\User;

class UserIndex
{

    private UserService $service;
    private Session $session;

    public function __construct(UserService $userService, Session $session)
    {
        $this->service = $userService;
        $this->session = $session;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->service->list($model->fromArray($request->getQueryParams()));
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $model->id = $request->getAttribute('id');
        $this->service->read($model);

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-need-not-auth
     */
    public function login(ServerRequestInterface $request, UserModelLogin $model): UserModelLogin
    {
        $model->fromArray($request->getQueryParams());
        $model->entity(new User);

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-need-auth
     */
    public function logout(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $model->id = $this->session->get('userId');

        $this->service->read($model);
        $this->session->set('userId', null);

        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-need-not-auth
     */
    public function doLogin(ServerRequestInterface $request, UserModelLogin $model): UserModelLogin
    {
        $model->fromArray($request->getParsedBody());

        $this->service->login($model);

        if ($model->isValid() && $model->entity()) {
            $this->session->set('userId', $model->entity()->id);
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

        $this->service->registation($model);

        return $model;
    }
    
}
