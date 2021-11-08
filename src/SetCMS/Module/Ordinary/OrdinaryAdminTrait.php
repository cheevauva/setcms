<?php

namespace SetCMS\Module\Ordinary;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

trait OrdinaryAdminTrait
{

    use OrdinaryIndexTrait;

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
