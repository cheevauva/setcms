<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

class OrdinaryModelList extends \SetCMS\Model
{

    public int $page = 0;
    private array $entities = [];

    public function entities(?array $entities = null): array
    {
        if (is_array($entities)) {
            $this->entities = $entities;
        }

        return $this->entities;
    }

    public function toArray(): array
    {
        return [
            'model' => $this,
            'entities' => $this->entities,
        ];
    }

}
