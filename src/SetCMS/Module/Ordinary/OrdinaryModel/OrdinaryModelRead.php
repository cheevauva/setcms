<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OrdinaryModelRead extends \SetCMS\Model
{

    /**
     * @setcms-required
     * @setcms-type-int
     * @var int 
     */
    public ?int $id = null;
    private ?OrdinaryEntity $entity = null;

    public function entity(?OrdinaryEntity $entity = null): ?OrdinaryEntity
    {
        if ($entity instanceof OrdinaryEntity) {
            $this->entity = $entity;
        }

        return $this->entity;
    }

    public function isValid(): bool
    {
        $this->messages = [];

        if (empty($this->id)) {
            $this->addMessage('Не указан идентификатор записи', 'id');
        }

        return parent::isValid();
    }

    public function toArray(): array
    {
        return [
            'model' => $this,
            'entity' => $this->entity,
        ];
    }

}
