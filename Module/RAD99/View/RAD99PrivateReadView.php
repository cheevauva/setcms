<?php

declare(strict_types=1);

namespace Module\RAD99\View;

use SetCMS\View\ViewTwig;
use Module\RAD99\Entity\RAD99Entity;
use UUA\DTO\SignedDTO;

class RAD99PrivateReadView extends ViewTwig
{

    public RAD99Entity $rad99;

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
            $object->object = $this->rad99;
        }
    }
}
