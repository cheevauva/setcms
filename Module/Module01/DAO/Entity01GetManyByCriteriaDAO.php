<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01EntitiesNotFoundException;

class Entity01GetManyByCriteriaDAO extends Entity01RetrieveByCriteriaDAO
{

    /**
     * @var array<Entity01Entity>
     */
    public array $entities;

    #[\Override]
    public function serve(): void
    {
        $this->entities = $this->entitiesFromRows($this->retrieveAll() ?: throw new Entity01EntitiesNotFoundException());
    }
}
