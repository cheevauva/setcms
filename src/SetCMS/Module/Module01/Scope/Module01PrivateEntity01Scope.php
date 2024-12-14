<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\UUID;
use SetCMS\Attribute\NotBlank;
use SetCMS\Module\Module01\Entity\Entity01Entity;

class Module01PrivateEntity01Scope extends Module01PrivateScope
{

    public UUID $id;

    #[NotBlank('field01')]
    public string $field01;

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01Entity) {
            $object->id = $this->id;
            $object->field01 = $this->field01;
        }
    }
}
