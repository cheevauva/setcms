<?php

declare(strict_types=1);

namespace Module\Configuration\Controller;

use SetCMS\Controller\ControllerBlockViaPSR7;
use Module\Configuration\View\ConfigurationPublicMainView;

class ConfigurationPublicMainController extends ControllerBlockViaPSR7
{
    #[\Override]
    protected function viewUnits(): array
    {
        return [
            ConfigurationPublicMainView::class,
        ];
    }


}
