<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Users\UserService;

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

}
