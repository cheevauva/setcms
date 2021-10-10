<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Pages\PageDAO;
use SetCMS\Module\Pages\Page;

class PageService extends OrdinaryService
{

    private PageDAO $dao;

    public function __construct(PageDAO $dao)
    {
        $this->dao = $dao;
    }

    protected function dao(): PageDAO
    {
        return $this->dao;
    }

    public function entity(): Page
    {
        return new Page;
    }

}
