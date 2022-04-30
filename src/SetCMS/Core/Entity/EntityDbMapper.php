<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity;

use SetCMS\ServantInterface;
use SetCMS\Core\Entity;

abstract class EntityDbMapper implements ServantInterface
{

    public ?Entity $entity = null;
    public ?\ArrayObject $row = null;

    protected function entity(): Entity
    {
        return $this->entity;
    }

    public function serve(): void
    {
        if (!$this->row) {
            $this->entity2row();
        } else {
            $this->entity4row();
        }
    }

    protected function entity2row(): void
    {
        $this->row['id'] = $this->entity->id;
        $this->row['type'] = $this->entity->entityType;
        $this->row['date_created'] = $this->entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $this->entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($this->entity->deleted);
    }

    protected function entity4row(): void
    {
        $this->entity = $this->entity ?? new $this->row['type'];
        $this->entity->id = $this->row['id'];
        $this->entity->dateCreated = new \DateTime($this->row['date_created']);
        $this->entity->dateModified = new \DateTime($this->row['date_modified']);
        $this->entity->deleted = boolval($this->row['deleted']);
    }

}
