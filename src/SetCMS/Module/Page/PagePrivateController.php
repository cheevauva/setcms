<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use \Psr\Http\Message\ServerRequestInterface;
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

    public function index(ServerRequestInterface $request, PagePrivateIndexScope $scope, PageRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function read(ServerRequestInterface $request, PagePrivateReadScope $scope, PageRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function new(ServerRequestInterface $request, PagePrivateEditScope $scope): PagePrivateEditScope
    {
        return $scope;
    }

    public function edit(ServerRequestInterface $request, PagePrivateEditScope $scope, PageRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function create(ServerRequestInterface $request, PagePrivateCreateScope $scope, PageSaveDAO $servant): PagePrivateCreateScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function update(ServerRequestInterface $request, PagePrivateUpdateScope $scope): PagePrivateUpdateScope
    {
        return $this->multiserve($request, [
            PageRetrieveByIdDAO::make($this->factory()),
            PageSaveDAO::make($this->factory())
        ], $scope);
    }

}
