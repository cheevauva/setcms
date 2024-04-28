<?php

declare(strict_types=1);

namespace SetCMS\Module\Block;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Block\Scope\BlockPublicSectionScope;
use SetCMS\Module\Block\DAO\BlockRetrieveManyBySectionDAO;

class BlockPublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function blocksBySection(ServerRequestInterface $request, BlockPublicSectionScope $scope, BlockRetrieveManyBySectionDAO $servant): BlockPublicSectionScope
    {
        return $this->serveServantWithScope($servant, $scope, [
            'section' => $request->getAttribute('section') ?? '',
        ]);
    }

}
