<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use Module\Module01\View\Entity01PrivateEditView;

class Entity01PrivateEditController extends Entity01PrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01PrivateEditView) {
            $object->Entity01LC = $this->Entity01LC;
        }
    }
}
