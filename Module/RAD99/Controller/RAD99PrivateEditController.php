<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use Module\RAD99\View\RAD99PrivateEditView;

class RAD99PrivateEditController extends RAD99PrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD99PrivateEditView) {
            $object->rad99 = $this->rad99;
        }
    }
}
