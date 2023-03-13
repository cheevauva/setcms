<?php

declare(strict_types=1);

namespace SetCMS\Module\Configuration;

use SetCMS\Module\Configuration\Scope\ConfigurationPublicMainScope;

class ConfigurationPublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function main(ConfigurationPublicMainScope $scope): ConfigurationPublicMainScope
    {
        return $scope;
    }

}
