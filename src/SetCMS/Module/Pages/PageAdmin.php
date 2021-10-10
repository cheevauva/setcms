<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Ordinary\OrdinaryController;
use SetCMS\Module\Pages\PageService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Pages\PageModel\PageModelSaveForm;
use SetCMS\Module\Pages\PageModel\PageModelSave;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;

class PageAdmin
{

    private PageService $service;
    private OrdinaryController $ordinary;

    public function __construct(PageService $service, OrdinaryController $ordinary)
    {
        $this->service = $service;

        $this->ordinary = $ordinary;
        $this->ordinary->service($service);
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
    public function saveform(ServerRequestInterface $request, PageModelSaveForm $modelEdit, OrdinaryModelRead $modelRead): OrdinaryModel
    {
        return $this->ordinary->saveform($request, $request->getAttribute('id') ? $modelRead : $modelEdit);
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function save(ServerRequestInterface $request, PageModelSave $model): PageModelSave
    {
        return $this->ordinary->save($request, $model);
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
