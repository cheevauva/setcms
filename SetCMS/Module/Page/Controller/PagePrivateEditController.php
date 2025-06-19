<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Module\Page\View\PagePrivateEditView;

class PagePrivateEditController extends PagePrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PagePrivateEditView) {
            $object->page = $this->page;
        }
    }
}
