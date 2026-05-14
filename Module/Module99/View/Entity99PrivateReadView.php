<?php

declare(strict_types=1);

namespace Module\Module99\View;

use SetCMS\View\ViewTwig;
use Module\Module99\Entity\Entity99Entity;
use UUA\DTO\SignedDTO;

class Entity99PrivateReadView extends ViewTwig
{

    public Entity99Entity $entity99;

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SignedDTO) {
            $this->assign($object->name, $object->object);
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SignedDTO && $object->name === 'entity') {
            $object->object = $this->entity99;
        }
    }
}
