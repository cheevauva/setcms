<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Pages\PageService;

class PageAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryControllerTrait;

    private PageService $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $this->service($pageService);
    }

}
