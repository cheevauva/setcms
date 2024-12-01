<?php

declare(strict_types=1);

namespace SetCMS\Module\Configuration\Controller;

use SetCMS\Module\Configuration\Scope\ConfigurationPublicMainScope;
use SetCMS\Module\Configuration\Scope\ConfigurationPublicAdminMenuScope;

class ConfigurationPublicController
{

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;

    public function main(ConfigurationPublicMainScope $scope): ConfigurationPublicMainScope
    {
        return $scope;
    }

    public function adminMemu(ConfigurationPublicAdminMenuScope $scope): ConfigurationPublicAdminMenuScope
    {
        return $scope;
    }

}
