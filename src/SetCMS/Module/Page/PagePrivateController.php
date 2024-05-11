<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

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

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PagePrivateIndexScope $scope, PageRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    public function read(PagePrivateReadScope $scope, PageRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    public function new(PagePrivateEditScope $scope): PagePrivateEditScope
    {
        return $scope;
    }

    public function edit(PagePrivateEditScope $scope, PageRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    public function create(PagePrivateCreateScope $scope, PageSaveDAO $servant): PagePrivateCreateScope
    {
        return $this->serve($servant, $scope);
    }

    public function update(PagePrivateUpdateScope $scope): PagePrivateUpdateScope
    {
        return $this->multiserve([
            PageRetrieveByIdDAO::make($this->factory()),
            PageSaveDAO::make($this->factory())
        ], $scope);
    }

}
