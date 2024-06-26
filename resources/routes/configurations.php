<?php

declare(strict_types=1);

use SetCMS\Module\Configuration\ConfigurationPublicController;

$routes['configurations_main'] = ['GET', '/sub/configurations/main', ConfigurationPublicController::toRoute()->main()];
$routes['admin_menu'] = ['GET', '/~/menu', ConfigurationPublicController::toRoute()->adminMemu()];