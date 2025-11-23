<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use UUA\Servant;
use SetCMS\UUID;
use SetCMS\Entity\Entity;
use SetCMS\DAO\EntityRetrieveManyByCriteriaDAO;
use SetCMS\DAO\EntityUpdateDAO;
use SetCMS\DAO\EntityDeleteByIdDAO;

/**
 * @template E of Entity
 */
abstract class EntityDeleteServant extends Servant
{

    public UUID $uuid;

    /**
     * @var E
     */
    public Entity $entity;
    public ?\Throwable $throwIfNotExists = null;
    public bool $safeDelete = true;

    /**
     * @var class-string
     */
    protected string $clsRetrieve;

    /**
     * @var class-string
     */
    protected string $clsUpdate;

    /**
     * @var class-string
     */
    protected string $clsDelete;

    #[\Override]
    public function serve(): void
    {
        $entityById = EntityRetrieveManyByCriteriaDAO::as(($this->clsRetrieve)::new($this->container));
        $entityById->id = $this->id ?? ($this->entity->id ?? throw new \RuntimeException('id is undefined'));
        $entityById->serve();

        if (isset($this->throwIfNotExists) && empty($entityById->first)) {
            throw $this->throwIfNotExists;
        }

        $entity = Entity::as($entityById->first);

        if ($this->safeDelete) {
            $this->safeDelete($entity);
        } else {
            $deleteById = EntityDeleteByIdDAO::as(($this->clsDelete)::new($this->container));
            $deleteById->id = $entity->id;
            $deleteById->serve();
        }
    }

    protected function safeDelete(Entity $entity): void
    {
        $entity->deleted = true;

        $update = EntityUpdateDAO::as(($this->clsUpdate)::new($this->container));
        $update->entity = $entity;
        $update->serve();
    }
}
