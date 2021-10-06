<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OrdinaryModelRead extends \SetCMS\Model
{

    /**
     * @setcms-type-int
     * @var int
     */
    public int $id = 0;
    private ?OrdinaryEntity $entity = null;

    public function entity(?OrdinaryEntity $entity = null): ?OrdinaryEntity
    {
        if ($entity instanceof OrdinaryEntity) {
            $this->entity = $entity;
        }

        return $this->entity;
    }

    public function toArray(): array
    {
        return [
            'model' => $this,
            'entity' => $this->entity,
        ];
    }

}
