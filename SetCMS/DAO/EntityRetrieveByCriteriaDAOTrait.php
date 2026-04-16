<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\UUID;
use SetCMS\Enum\SortEnum;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;

trait EntityRetrieveByCriteriaDAOTrait
{

    public bool $expectOne = false;
    public bool $allowEmptyResult = true;
    //
    public ?int $limit = null;
    public int $offset = 0;
    public UUID $id;
    public bool $deleted;
    public string $entityType;
    public UUID $assignedBy;
    public UUID $createdBy;
    public UUID $modifiedBy;
    public \DateTimeImmutable $dateCreatedFrom;
    public \DateTimeImmutable $dateCreatedTo;
    public \DateTimeImmutable $dateModifiedFrom;
    public \DateTimeImmutable $dateModifiedTo;
    public SortEnum $sortByDateCreated;
    public SortEnum $sortByDateModified;

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
        $rows = $this->createQuery()->fetchAllAssociative();

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

    abstract protected function createQb(): DatabaseQueryBuilder;

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table());
        $qb->setMaxResults($this->limit);
        $qb->setFirstResult($this->offset);

        if (isset($this->id)) {
            $this->criteria['id'] ??= $this->id;
        }

        if (isset($this->createdBy)) {
            $this->criteria['created_by'] = $this->createdBy;
        }

        if (isset($this->modifiedBy)) {
            $this->criteria['modified_by'] = $this->modifiedBy;
        }

        if (isset($this->assignedBy)) {
            $this->criteria['assigned_by'] = $this->assignedBy;
        }

        if (isset($this->entityType)) {
            $this->criteria['entity_type'] = $this->entityType;
        }

        if (isset($this->deleted)) {
            $qb->andWhere('deleted = :deleted');
            $qb->setParameter('deleted', intval($this->deleted));
        }

        if (isset($this->dateCreatedFrom)) {
            $qb->andWhere('date_created >= :dateCreatedFrom');
            $qb->setParameter('dateCreatedFrom', $this->dateCreatedFrom->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateCreatedTo)) {
            $qb->andWhere('date_created <= :dateCreatedTo');
            $qb->setParameter('dateCreatedTo', $this->dateCreatedTo->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateModifiedFrom)) {
            $qb->andWhere('date_modified >= :dateModifiedFrom');
            $qb->setParameter('dateModifiedFrom', $this->dateModifiedFrom->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateModifiedTo)) {
            $qb->andWhere('date_modified <= :dateModifiedTo');
            $qb->setParameter('dateModifiedTo', $this->dateModifiedTo->format('Y-m-d H:i:s'));
        }

        if (isset($this->sortByDateCreated)) {
            $qb->addOrderBy('date_created', $this->sortByDateCreated->value);
        }

        if (isset($this->sortByDateModified)) {
            $qb->addOrderBy('date_modified', $this->sortByDateModified->value);
        }

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s.%s = :%s', $this->table(), $field, $field));
            $qb->setParameter($field, strval($value));
        }

        return $qb;
    }
}
