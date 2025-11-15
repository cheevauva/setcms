<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use Module\Post\View\PostPrivateNewView;

class PostPrivateNewController extends PostPrivateController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateNewView::class,
        ];
    }
}
