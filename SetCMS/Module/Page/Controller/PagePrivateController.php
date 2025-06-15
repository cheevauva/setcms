<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Module\Page\DAO\PageRetrieveManyDAO;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\Scope\PagePrivateReadController;
use SetCMS\Module\Page\Scope\PagePrivateEditController;
use SetCMS\Module\Page\Scope\PagePrivateIndexController;
use SetCMS\Module\Page\Scope\PagePrivateCreateController;
use SetCMS\Module\Page\Scope\PagePrivateUpdateController;
use SetCMS\Module\Page\DAO\PageSaveDAO;

class PagePrivateController
{

    public function index(PagePrivateIndexController $scope, PageRetrieveManyDAO $servant): PagePrivateIndexController
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function read(PagePrivateReadController $scope, PageRetrieveByIdDAO $servant): PagePrivateReadController
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function new(PagePrivateEditController $scope): PagePrivateEditController
    {
        return $scope;
    }

    public function edit(PagePrivateEditController $scope, PageRetrieveByIdDAO $servant): PagePrivateEditController
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function create(PagePrivateCreateController $scope, PageSaveDAO $servant): PagePrivateCreateController
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function update(PagePrivateUpdateController $scope): PagePrivateUpdateController
    {
        $this->multiserve([
            PageRetrieveByIdDAO::new($this->container),
            PageSaveDAO::new($this->container)
        ], $scope);

        return $scope;
    }
}
