<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Post\View\PostPrivateEditView;

#[RequestMethod('GET')]
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
            $object->post = $this->entity;
        }
    }
}
