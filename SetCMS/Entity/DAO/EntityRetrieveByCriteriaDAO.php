<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;

abstract class EntityRetrieveByCriteriaDAO extends \UUA\DAO
{

    public bool $expectOne = false;
    public bool $allowEmptyResult = true;
    //
    public ?int $limit = null;
    public int $offset = 0;
    public UUID $id;
    public bool $sortIdAsc;

    /**
     * @var array<string, mixed>
     */
    protected array $criteria = [];

    abstract protected function entitiesNotFoundException(): \Throwable;

    abstract protected function entityExpectOneButReceivedTooMuchException(): \Throwable;

    abstract protected function entityNotFoundException(): \Throwable;

    #[\Override]
    public function serve(): void
    {
        $rows = $this->createQb()->fetchAllAssociative();

        $this->checkRows($rows);
        $this->handleRows($rows);
    }

    /**
     * @param array<int,array<string, mixed>> $rows
     * @return void
     */
    protected function checkRows(array $rows): void
    {
        if ($this->expectOne) {
            if (count($rows) > 1) {
                throw $this->entityExpectOneButReceivedTooMuchException();
            }
            if (empty($rows) && !$this->allowEmptyResult) {
                throw $this->entityNotFoundException();
            }
        } else {
            if (empty($rows) && !$this->allowEmptyResult) {
                throw $this->entitiesNotFoundException();
            }
        }
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     */
    abstract protected function handleRows(array $rows): void;

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQb(): DatabaseQueryBuilder
    {
        return $this->createQuery();
    }

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->table(), 't');
        $qb->setMaxResults($this->limit);
        $qb->setFirstResult($this->offset);

        if (isset($this->id)) {
            $qb->andWhere('id = :id');
            $qb->setParameter('id', $this->id->uuid);
        }

        if (isset($this->sortIdAsc)) {
            $qb->addOrderBy('id', $this->sortIdAsc ? 'ASC' : 'DESC');
        }

        return $qb;
    }
}
