<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Controller;

use SetCMS\Module\Email\View\EmailPrivateEditView;

class EmailPrivateEditController extends EmailPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            EmailPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailPrivateEditView) {
            $object->email = $this->email;
        }
    }
}
