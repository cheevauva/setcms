<?php

namespace SetCMS\Module\Page;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveManyDAO;
use SetCMS\Module\Page\Scope\PagePrivateIndexScope;
use SetCMS\Module\Page\Scope\PagePrivateEditScope;
use SetCMS\Module\Page\Scope\PagePrivateReadScope;

class PagePrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PagePrivateIndexScope $scope, PageEntityDbRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function new(ServerRequestInterface $request, PagePrivateEditScope $scope): PagePrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function read(ServerRequestInterface $request, PagePrivateReadScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }


    public function edit(ServerRequestInterface $request, PagePrivateEditScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }


}
