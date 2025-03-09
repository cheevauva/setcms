<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

use SetCMS\Common\Entity\Entity;

abstract class EntityRetrieveManyDAO extends EntityCommonDAO
{

    public array $entities;
    public Entity $first;

    public function serve(): void
    {
        $this->entities = $this->asEntities($this->createQuery()->executeQuery()->fetchAllAssociative() ?: []);
    }
}
