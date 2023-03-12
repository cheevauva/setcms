<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Page\DAO\PageRetrieveByIdDAO;
use SetCMS\Module\Page\DAO\PageRetrieveBySlugDAO;
use SetCMS\Module\Page\Scope\PagePublicReadScope;
use SetCMS\Module\Page\Scope\PagePublicReadBlockScope;

class PagePublicController
{

    use \SetCMS\ControllerTrait;

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function read(ServerRequestInterface $request, PagePublicReadScope $scope, PageRetrieveByIdDAO $servant): PagePublicReadScope
    {
        $servant->throwExceptionIfNotFound = true;

        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function block(ServerRequestInterface $request, PagePublicReadBlockScope $scope, PageRetrieveBySlugDAO $servant): PagePublicReadBlockScope
    {
        return $this->serve($request, $servant, $scope, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
