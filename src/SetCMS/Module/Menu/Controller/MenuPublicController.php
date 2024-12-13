<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Module\Menu\Scope\MenuPublicReadByContextScope;
use SetCMS\Module\Menu\Scope\MenuPublicReadBySlugScope;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyBySlugDAO;
use SetCMS\Module\Menu\Hook\MenuRetrieveActionsByContextHook;

class MenuPublicController
{

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;
    
    public function readByContext(MenuPublicReadByContextScope $scope): MenuPublicReadByContextScope
    {
        return $this->serve(MenuRetrieveActionsByContextHook::class, $scope);
    }

    public function readBySlug(MenuPublicReadBySlugScope $scope): MenuPublicReadBySlugScope
    {
        return $this->serve(MenuRetrieveManyBySlugDAO::class, $scope);
    }

}
