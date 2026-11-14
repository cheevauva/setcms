<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;
use SetCMS\Entity\Entity;
use SetCMS\Entity\Exception\EntitiesNotFoundException;
use SetCMS\Entity\Exception\EntityExpectOneButReceivedTooMuchException;
use SetCMS\Entity\Exception\EntityNotFoundException;

/**
 * @template T of Entity
 */
abstract class EntityRetrieveByCriteriaDAO extends \UUA\DAO
{

    use \UUA\Traits\WrappingTrait;

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

    /**
     * @var T
     */
    public protected(set) Entity $entity;

    /**
     * @var T|null
     */
    public protected(set) ?Entity $entityOrNull = null;

    /**
     * @var T[]
     */
    public protected(set) array $entities;

    protected function entitiesNotFoundException(): \Throwable
    {
        return new EntitiesNotFoundException;
    }

    protected function entityExpectOneButReceivedTooMuchException(): EntityExpectOneButReceivedTooMuchException
    {
        return new EntityExpectOneButReceivedTooMuchException;
    }

    protected function entityNotFoundException(): EntityNotFoundException
    {
        return new EntityNotFoundException;
    }

    #[\Override]
    protected function run(): void
    {
        $rows = $this->createQb()->fetchAllAssociative();

        $this->checkRows($rows);
        $this->entities = array_map($this->rowToEntity(...), $rows);
        $this->entities ? $this->entity = $this->entityOrNull = $this->entities[0] : null;
    }

    /**
     * @param array<int,array<string, mixed>> $rows
     * @return void
     */
    protected function checkRows(array $rows): void
    {
        if ($this->expectOne) {
            if (count($rows) > 1) {
                throw new EntityExpectOneButReceivedTooMuchException();
            }
            if (empty($rows) && !$this->allowEmptyResult) {
                throw new EntityNotFoundException();
            }
        } else {
            if (empty($rows) && !$this->allowEmptyResult) {
                throw new EntitiesNotFoundException;
            }
        }
    }

    /**
     * @param array<string, mixed> $row
     * @return T
     */
    abstract protected function rowToEntity(array $row): Entity;

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQb(): DatabaseQueryBuilder
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
