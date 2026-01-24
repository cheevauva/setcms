<?php

declare(strict_types=1);

namespace Module\Module01\View;

use SetCMS\View\ViewTwig;
use Module\Module01\Entity\Entity01Entity;
use UUA\DTO\SignedDTO;

class Entity01PrivateReadView extends ViewTwig
{

    public Entity01Entity $entity;

    #[\Override]
    public function from(object $object): void
    {
        if ($object instanceof SignedDTO) {
            $this->assign($object->name, $object->object);
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        if ($object instanceof SignedDTO && $object->name === 'entity') {
            $object->object = $this->entity;
        }
    }
}
