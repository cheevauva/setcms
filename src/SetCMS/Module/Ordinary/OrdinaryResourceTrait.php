<?php

namespace SetCMS\Module\Ordinary;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;

trait OrdinaryResourceTrait
{

    private OrdinaryService $service;

    private function service(?OrdinaryService $service = null): OrdinaryService
    {
        if (!is_null($service)) {
            $this->service = $service;
        }

        return $this->service;
    }

    private function save(ServerRequestInterface $request, OrdinaryModel $model): OrdinaryModel
    {
        $model->fromArray($request->getParsedBody());

        if ($model->isValid()) {
            $this->service()->save($model);
        }

        return $model;
    }

    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        return $this->service()->read($request, $model);
    }

    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->service()->index($request, $model);
    }

}
