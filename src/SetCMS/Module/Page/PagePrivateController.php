<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Attribute\Http\RequestMethod;
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

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;

    #[RequestMethod('GET')]
    public function index(PagePrivateIndexScope $scope, PageRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function read(PagePrivateReadScope $scope, PageRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function new(PagePrivateEditScope $scope): PagePrivateEditScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function edit(PagePrivateEditScope $scope, PageRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function create(PagePrivateCreateScope $scope, PageSaveDAO $servant): PagePrivateCreateScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function update(PagePrivateUpdateScope $scope): PagePrivateUpdateScope
    {
        return $this->multiserve([
            PageRetrieveByIdDAO::make($this->factory()),
            PageSaveDAO::make($this->factory())
        ], $scope);
    }

}
