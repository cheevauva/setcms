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

    public function index(ServerRequestInterface $request, PagePrivateIndexScope $scope, PageEntityDbRetrieveManyDAO $servant): PagePrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    public function new(PagePrivateEditScope $scope): PagePrivateEditScope
    {
        return $scope;
    }

    public function read(ServerRequestInterface $request, PagePrivateReadScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->serve($servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PagePrivateSaveScope $form, PageEntitySaveServant $servant): PagePrivateSaveScope
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($servant, $form, $request->getParsedBody());
    }

    public function edit(ServerRequestInterface $request, PagePrivateEditScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->serve($servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function delete(ServerRequestInterface $request, PageDeleteForm $form, PageEntitySaveServant $servant): PageDeleteForm
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

}
