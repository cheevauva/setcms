<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Pages\PageService;
use SetCMS\Module\Ordinary\OrdinaryResourceController;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Pages\PageModel\PageModelSave;

class PageResource
{

    private OrdinaryResourceController $ordinaryAdmin;

    public function __construct(PageService $oageService, OrdinaryResourceController $ordinaryAdmin)
    {
        $this->ordinaryAdmin = $ordinaryAdmin;
        $this->ordinaryAdmin->service($oageService);
    }

    public function update(ServerRequestInterface $request, PageModelSave $model): PageModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

    public function create(ServerRequestInterface $request, PageModelSave $model): PageModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

}
