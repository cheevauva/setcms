<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Menu\Scope\MenuPublicAdminMenuScope;
use SetCMS\Module\Menu\Scope\MenuPrivateIndexScope;
use SetCMS\Module\Menu\Scope\MenuPrivateEditScope;
use SetCMS\Module\Menu\Scope\MenuPrivateCreateScope;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyDAO;
use SetCMS\Module\Menu\DAO\MenuSaveDAO;
use SetCMS\Module\Menu\DAO\MenuRetrieveByIdDAO;

class MenuPrivateController
{

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;

    public function adminMemu(MenuPublicAdminMenuScope $scope): MenuPublicAdminMenuScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function index(MenuPrivateIndexScope $scope, MenuRetrieveManyDAO $servant): MenuPrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function new(MenuPrivateEditScope $scope): MenuPrivateEditScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function edit(MenuPrivateEditScope $scope, MenuRetrieveByIdDAO $servant): MenuPrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function create(MenuPrivateCreateScope $scope, MenuSaveDAO $servant): MenuPrivateCreateScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function update(MenuPrivateUpdateScope $scope): MenuPrivateUpdateScope
    {
        return $this->multiserve([
            MenuRetrieveByIdDAO::make($this->factory()),
            MenuSaveDAO::make($this->factory())
        ], $scope);
    }
}
