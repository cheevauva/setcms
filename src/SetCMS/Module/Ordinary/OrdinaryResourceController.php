<?php

namespace SetCMS\Module\Ordinary;

use SetCMS\Module\Ordinary\OrdinaryController;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use Psr\Http\Message\ServerRequestInterface;

class OrdinaryResourceController extends OrdinaryController
{

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function save(ServerRequestInterface $request, OrdinaryModel $model): OrdinaryModel
    {
        $model->fromArray($request->getParsedBody());

        if ($model->isValid()) {
            $this->service()->save($model);
        }

        return $model;
    }

}
