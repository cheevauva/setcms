<?php

declare(strict_types=1);

use SetCMS\Module\Configuration\Controller\ConfigurationPublicController;

$routes['configurations_main'] = ConfigurationPublicController::toRoute('GET', '/sub/configurations/main')->main();