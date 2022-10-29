<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

abstract class EntityEditScope extends EntityReadScope
{

    public function toArray(): array
    {
        return [
            'entity' => $this->entity,
        ];
    }

}
