<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\Module\Module01\Entity01Entity;

trait Module01PrivateEntityScopeTrait
{

    public $field01;

    public function satisfy(): \Iterator
    {
        parent::satisfy();

        if (0) {
            yield ['', ''];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01Entity) {
            $object->field01 = $this->field01;
        }
    }

}
