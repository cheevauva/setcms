<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Post\View\PostPrivateNewView;

#[RequestMethod('GET')]
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
