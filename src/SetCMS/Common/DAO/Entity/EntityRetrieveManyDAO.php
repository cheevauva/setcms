<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

abstract class EntityRetrieveManyDAO extends EntityCommonDAO implements \SetCMS\Application\Contract\ContractServant
{

    public array $entities;

    public function serve(): void
    {
        $this->entities = $this->asEntities($this->createQuery()->executeQuery()->fetchAllAssociative() ?: []);
    }
}
