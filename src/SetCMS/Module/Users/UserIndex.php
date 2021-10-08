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
    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $model->id = $request->getAttribute('id');
        $this->service->read($model);

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function login(ServerRequestInterface $request, UserModelLogin $model): UserModelLogin
    {
        if ($this->session->get('userId')) {
            throw UserException::alreadyAuthorized();
        }

        $model->fromArray($request->getQueryParams());
        $model->entity(new User);

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function logout(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        if (!$this->session->get('userId')) {
            throw UserException::notAllow('Нужно авторизоваться чтобы выйти');
        }

        $model->id = $this->session->get('userId');

        $this->service->read($model);
        $this->session->set('userId', null);

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

        if ($model->isValid() && $model->entity()) {
            $this->session->set('userId', $model->entity()->id);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function registration(UserModelRegistration $model): UserModelRegistration
    {
        if ($this->session->get('userId')) {
            throw UserException::alreadyAuthorized();
        }

        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-access-level-index
     */
    public function doRegistration(ServerRequestInterface $request, UserModelRegistration $model): UserModelRegistration
    {
        $model->fromArray($request->getParsedBody());

        $this->service->registation($model);

        return $model;
    }

}
