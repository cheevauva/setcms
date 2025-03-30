<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Module\Page\DAO\PageRetrieveManyDAO;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\Scope\PagePrivateReadScope;
use SetCMS\Module\Page\Scope\PagePrivateEditScope;
use SetCMS\Module\Page\Scope\PagePrivateIndexScope;
use SetCMS\Module\Page\Scope\PagePrivateCreateScope;
use SetCMS\Module\Page\Scope\PagePrivateUpdateScope;
use SetCMS\Module\Page\DAO\PageSaveDAO;

class PagePrivateController
{

    public function index(PagePrivateIndexScope $scope, PageRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function read(PagePrivateReadScope $scope, PageRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function new(PagePrivateEditScope $scope): PagePrivateEditScope
    {
        return $scope;
    }

    public function edit(PagePrivateEditScope $scope, PageRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function create(PagePrivateCreateScope $scope, PageSaveDAO $servant): PagePrivateCreateScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function update(PagePrivateUpdateScope $scope): PagePrivateUpdateScope
    {
        $this->multiserve([
            PageRetrieveByIdDAO::new($this->container),
            PageSaveDAO::new($this->container)
        ], $scope);

        return $scope;
    }
}
