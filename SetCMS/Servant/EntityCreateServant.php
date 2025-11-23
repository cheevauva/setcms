<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use UUA\Servant;
use SetCMS\Entity\Entity;
use SetCMS\DAO\EntityHasByIdDAO;
use SetCMS\DAO\EntityCreateDAO;

/**
 * @template E of Entity
 */
abstract class EntityCreateServant extends Servant
{

    /**
     * @var class-string
     */
    protected string $clsHasById;

    /**
     * @var class-string
     */
    protected string $clsCreate;

    /**
     * @var E
     */
    public Entity $entity;
    public ?\Throwable $throwIfNotExists = null;

    #[\Override]
    public function serve(): void
    {
        $hasById = EntityHasByIdDAO::as(($this->clsHasById)::new($this->container));
        $hasById->id = $this->entity->id;
        $hasById->serve();

        if (isset($this->throwIfNotExists) && !$hasById->isExists) {
            throw $this->throwIfNotExists;
        }

        $create = EntityCreateDAO::as(($this->clsCreate)::new($this->container));
        $create->entity = $this->entity;
        $create->serve();
    }
}
