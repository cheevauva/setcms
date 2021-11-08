<?php

namespace SetCMS\Module\Pages;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Pages\PageService;
use SetCMS\Module\Pages\PageModel\PageModelSave;

class PageResource
{

    use \SetCMS\Module\Ordinary\OrdinaryResourceTrait;

    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $this->service($pageService);
    }

    public function update(ServerRequestInterface $request, PageModelSave $model): PageModelSave
    {
        return $this->save($request, $model);
    }

    public function create(ServerRequestInterface $request, PageModelSave $model): PageModelSave
    {
        return $this->save($request, $model);
    }

}
