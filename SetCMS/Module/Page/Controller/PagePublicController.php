<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageRetrieveBySlugDAO;
use SetCMS\Module\Page\Scope\PagePublicReadScope;
use SetCMS\Module\Page\Scope\PagePublicReadBlockScope;

class PagePublicController
{

    public function read(PagePublicReadScope $scope, PageRetrieveByIdDAO $servant): PagePublicReadScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function block(PagePublicReadBlockScope $scope, PageRetrieveBySlugDAO $servant): PagePublicReadBlockScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }
}
