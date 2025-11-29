<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01EntityExpectOneButReceivedTooMuchException;

class Entity01FindOneByCriteriaDAO extends Entity01RetrieveByCriteriaDAO
{

    public protected(set) ?Entity01Entity $entity = null;
    public ?int $limit = 1;

    #[\Override]
    public function handleRows(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        if (count($rows) > 1) {
            throw new Entity01EntityExpectOneButReceivedTooMuchException;
        }

        $this->entity = $this->entitiesFromRows($rows)[0] ?? null;
    }
}
