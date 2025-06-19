<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO;

use SetCMS\Common\Entity\Entity;

abstract class EntityRetrieveManyDAO extends EntityCommonDAO
{

    /**
     * @var Entity[]
     */
    protected array $entities;
    protected ?Entity $first = null;

    #[\Override]
    public function serve(): void
    {
        $this->entities = $this->asEntities($this->createQuery()->executeQuery()->fetchAllAssociative() ?: []);
        $this->first = $this->entities[0] ?? null;
    }
}
