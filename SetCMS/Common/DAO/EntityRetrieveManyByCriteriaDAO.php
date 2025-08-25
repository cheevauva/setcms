<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Common\Entity\Entity;
use SetCMS\UUID;

abstract class EntityRetrieveManyByCriteriaDAO extends EntityCommonDAO
{

    /**
     * @var array<string, mixed>
     */
    protected array $criteria = [];
    public ?Entity $first = null;

    /**
     * @var array<Entity>
     */
    public array $entities = [];
    public UUID $id;
    public bool $deleted;
    public bool $orThrow = false;

    #[\Override]
    public function serve(): void
    {
        $rows = $this->createQuery()->fetchAllAssociative();

        if ($this->orThrow && empty($rows)) {
            throw $this->notFoundExcecption();
        }

        $this->entities = $this->asEntities($rows);
        $this->first = $this->entities[0] ?? null;
    }

    abstract protected function notFoundExcecption(): \Throwable;

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = parent::createQuery();

        if (isset($this->deleted)) {
            $this->criteria['deleted'] = intval($this->deleted);
        }

        if (isset($this->id)) {
            $this->criteria['id'] = $this->id;
            $this->limit = 1;
        }

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s.%s = :%s', $this->table(), $field, $field));
            $qb->setParameter($field, $value);
        }

        return $qb;
    }
}
