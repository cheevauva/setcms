<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01EntityNotFoundException;
use Module\Module01\Exception\Entity01EntityExpectOneButReceivedTooMuchException;

class Entity01GetOneByCriteriaDAO extends Entity01RetrieveByCriteriaDAO
{

    use Entity01CommonDAO;

    public protected(set) Entity01Entity $entity;
    public ?int $limit = 1;

    #[\Override]
    public function serve(): void
    {
        $rows = $this->retrieveAll();

        if (empty($rows)) {
            throw new Entity01EntityNotFoundException;
        }

        if (count($rows) > 1) {
            throw new Entity01EntityExpectOneButReceivedTooMuchException;
        }

        $this->entity = $this->entitiesFromRows($rows)[0];
    }
}
