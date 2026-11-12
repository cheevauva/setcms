<?php

declare(strict_types=1);

namespace Module\Configuration\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Configuration\View\ConfigurationPublicMainView;

class ConfigurationPublicMainController extends ControllerViaPSR7
{
    #[\Override]
    protected function viewUnits(): array
    {
        return [
            ConfigurationPublicMainView::class,
        ];
    }


}
