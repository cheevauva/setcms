<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use Module\Post\View\PostPrivateEditView;

class PostPrivateEditController extends PostPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostPrivateEditView) {
            $object->post = $this->post;
        }
    }
}
