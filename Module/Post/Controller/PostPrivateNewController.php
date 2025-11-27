<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\View\PostPrivateNewView;

class PostPrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateNewView::class,
        ];
    }
}
