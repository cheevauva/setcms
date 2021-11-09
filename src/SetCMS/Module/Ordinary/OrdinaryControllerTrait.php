<?php

namespace SetCMS\Module\Ordinary;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

trait OrdinaryControllerTrait
{

    private OrdinaryService $service;

    public function service(?OrdinaryService $service = null): OrdinaryService
    {
        if (!is_null($service)) {
            $this->service = $service;
        }

        return $this->service;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        $model->fromArray($request->getQueryParams());

        if ($model->isValid()) {
            $this->service()->list($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id');

        $model->fromArray($params);

        if ($model->isValid()) {
            $this->service()->read($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function save(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModel
    {
        if ($request->getAttribute('id')) {
            $params = $request->getQueryParams();
            $params['id'] = $request->getAttribute('id');

            $model->fromArray($params);

            if ($model->isValid()) {
                $this->service()->read($model);
            }
        } else {
            $model->fromArray($request->getQueryParams());
            $model->entity($this->service()->entity());
        }

        return $model;
    }

}
