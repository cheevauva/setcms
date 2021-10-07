<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

use SetCMS\Module\Ordinary\OrdinaryEntity;

abstract class OrdinaryModel extends \SetCMS\Model
{

    private ?OrdinaryEntity $entity = null;

    public function entity(?OrdinaryEntity $entity = null): OrdinaryEntity
    {
        if ($entity instanceof OrdinaryEntity) {
            $this->entity = $this->bind($entity);
        }

        return $this->entity;
    }

    /**
     * Предназначен для связывания полей этой модели и сущности
     */
    protected function bind(OrdinaryEntity $entity): OrdinaryEntity
    {
        return $entity;
    }

    public function toArray(): array
    {
        return [
            'model' => $this,
            'entity' => $this->entity,
        ];
    }

}
