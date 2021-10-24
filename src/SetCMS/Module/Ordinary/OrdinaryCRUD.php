<?php

namespace SetCMS\Module\Ordinary;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Ordinary\OrdinaryController;
use Psr\Http\Message\ServerRequestInterface;

trait OrdinaryCRUD
{

    private $ordinary;

    private function ordinary(?OrdinaryController $ordinary = null): OrdinaryController
    {
        if ($ordinary instanceof OrdinaryController) {
            $this->ordinary = $ordinary;
        }

        return $this->ordinary;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function save(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModel
    {
        return $this->ordinary->save($request, $model);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->ordinary->index($request, $model);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        return $this->ordinary->read($request, $model);
    }

}
