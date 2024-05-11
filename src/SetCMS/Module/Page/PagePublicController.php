<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageRetrieveBySlugDAO;
use SetCMS\Module\Page\Scope\PagePublicReadScope;
use SetCMS\Module\Page\Scope\PagePublicReadBlockScope;

class PagePublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function read(PagePublicReadScope $scope, PageRetrieveByIdDAO $servant): PagePublicReadScope
    {
        return $this->serve($servant, $scope);
    }

    public function block(PagePublicReadBlockScope $scope, PageRetrieveBySlugDAO $servant): PagePublicReadBlockScope
    {
        return $this->serve($servant, $scope);
    }

}
