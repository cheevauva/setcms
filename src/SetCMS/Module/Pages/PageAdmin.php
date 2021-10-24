<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Ordinary\OrdinaryController;
use SetCMS\Module\Pages\PageService;

class PageAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryCRUD;

    public function __construct(PageService $service, OrdinaryController $ordinary)
    {

        $this->ordinary(clone $ordinary);
        $this->ordinary()->service($service);
    }

}
