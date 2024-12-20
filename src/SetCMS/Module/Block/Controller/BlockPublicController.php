<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Controller;

use SetCMS\Module\Block\Scope\BlockPublicSectionScope;
use SetCMS\Module\Block\DAO\BlockRetrieveManyBySectionDAO;

class BlockPublicController
{

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;

    public function blocksBySection(BlockPublicSectionScope $scope, BlockRetrieveManyBySectionDAO $servant): BlockPublicSectionScope
    {
        $this->serveScope($scope);
        $this->serveServantWithScope($servant, $scope);

        return $scope;
    }

}
