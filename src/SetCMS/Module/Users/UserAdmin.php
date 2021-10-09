<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;

class UserAdmin
{

    private UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->service->list($model->fromArray($request->getQueryParams()));
    }

}
