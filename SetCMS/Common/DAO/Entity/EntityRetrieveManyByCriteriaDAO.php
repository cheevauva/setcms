<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Common\Entity\Entity;
use SetCMS\UUID;

abstract class EntityRetrieveManyByCriteriaDAO extends EntityCommonDAO
{

    protected array $criteria = [];
    public ?Entity $first = null;
    public array $entities = [];
    public UUID $id;
    public bool $deleted;
    public bool $orThrow = false;

    public function serve(): void
    {
        if (isset($this->deleted)) {
            $this->criteria['deleted'] = intval($this->deleted);
        }

        if (isset($this->id)) {
            $this->criteria['id'] = $this->id;
            $this->limit = 1;
        }

        $rows = $this->createQuery()->fetchAllAssociative();

        if ($this->orThrow && empty($rows)) {
            throw new \RuntimeException('Запись не найдена');
        }

        $this->entities = $this->asEntities($rows);
        $this->first = $this->entities[0] ?? null;
    }

    protected function createQuery(): QueryBuilder
    {
        $qb = parent::createQuery();

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s.%s = :%s', $this->table(), $field, $field));
            $qb->setParameter($field, $value);
        }

        return $qb;
    }
}
