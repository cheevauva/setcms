<?php

declare(strict_types=1);

namespace Module\RAD01\Controller;

use Module\RAD01\View\RAD01PrivateEditView;

class RAD01PrivateEditController extends RAD01PrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD01PrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD01PrivateEditView) {
            $object->rad01 = $this->rad01;
        }
    }
}
