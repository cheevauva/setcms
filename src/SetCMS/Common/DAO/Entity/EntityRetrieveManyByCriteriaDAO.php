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
    public bool $deleted = false;
    public bool $throwExceptionIfNotFound = false;

    public function serve(): void
    {
        if (isset($this->id)) {
            $this->criteria = [
                'id' => $this->id,
                'deleted' => (int) $this->deleted,
            ];
            $this->limit = 1;
        }

        $rows = $this->createQuery()->fetchAllAssociative();

        if ($this->throwExceptionIfNotFound && empty($rows)) {
            throw new \RuntimeException('Запись не найдена');
        }

        $this->entities = $this->asEntities($rows);
        $this->first = $this->entities[0];
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
