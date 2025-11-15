<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Template\View\TemplatePrivateNewView;

class TemplatePrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            TemplatePrivateNewView::class,
        ];
    }
}
