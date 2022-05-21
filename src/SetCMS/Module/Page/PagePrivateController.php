<?php

namespace SetCMS\Module\Page;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Page\Servant\PageEntitySaveServant;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveManyDAO;
use SetCMS\Module\Page\Scope\PagePrivateIndexScope;
use SetCMS\Module\Page\Scope\PagePrivateEditScope;
use SetCMS\Module\Page\Scope\PagePrivateSaveScope;
use SetCMS\Module\Page\Scope\PagePrivateReadScope;

class PagePrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PagePrivateIndexScope $scope, PageEntityDbRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        return $this->protectedServe($request, $servant, $scope, []);
    }

    public function new(ServerRequestInterface $request, PagePrivateEditScope $scope): PagePrivateEditScope
    {
        $this->protectScopeByRequest($scope, $request);

        return $scope;
    }

    public function read(ServerRequestInterface $request, PagePrivateReadScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PagePrivateSaveScope $form, PageEntitySaveServant $servant): PagePrivateSaveScope
    {
        $servant->id = $request->getAttribute('id');

        return $this->protectedServe($request, $servant, $form, $request->getParsedBody());
    }

    public function edit(ServerRequestInterface $request, PagePrivateEditScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function delete(ServerRequestInterface $request, PageDeleteForm $form, PageEntitySaveServant $servant): PageDeleteForm
    {
        return $this->protectedServe($request, $servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

}
