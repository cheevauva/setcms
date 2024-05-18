<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu;

use SetCMS\Module\Menu\Scope\MenuPublicReadBySlugScope;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyBySlugDAO;

class MenuPublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function readBySlug(MenuPublicReadBySlugScope $scope): MenuPublicReadBySlugScope
    {
        return $this->serve(MenuRetrieveManyBySlugDAO::class, $scope);
    }

}
