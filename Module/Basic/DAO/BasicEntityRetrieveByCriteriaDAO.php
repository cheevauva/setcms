<?php

declare(strict_types=1);

namespace Module\Basic\DAO;

use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;

abstract class BasicEntityRetrieveByCriteriaDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    public bool $deleted;
    public string $entityType;
    public UUID $assignedBy;
    public UUID $createdBy;
    public UUID $modifiedBy;
    public \DateTimeImmutable $dateCreated;
    public \DateTimeImmutable $dateCreatedFrom;
    public \DateTimeImmutable $dateCreatedTo;
    public \DateTimeImmutable $dateModified;
    public \DateTimeImmutable $dateModifiedFrom;
    public \DateTimeImmutable $dateModifiedTo;
    public bool $sortDateCreatedASC;
    public bool $sortDateModifiedASC;

    protected function basicQb(DatabaseQueryBuilder $qb): void
    {
        if (isset($this->createdBy)) {
            $qb->andWhere('created_by = :createdBy');
            $qb->setParameter('createdBy', $this->createdBy->uuid);
        }

        if (isset($this->modifiedBy)) {
            $qb->andWhere('modified_by = :modifiedBy');
            $qb->setParameter('modifiedBy', $this->modifiedBy->uuid);
        }

        if (isset($this->assignedBy)) {
            $qb->andWhere('assigned_by = :assignedBy');
            $qb->setParameter('assignedBy', $this->assignedBy->uuid);
        }

        if (isset($this->entityType)) {
            $qb->andWhere('entity_type = :entityType');
            $qb->setParameter('entityType', $this->entityType);
        }

        if (isset($this->deleted)) {
            $qb->andWhere('deleted = :deleted');
            $qb->setParameter('deleted', intval($this->deleted));
        }

        if (isset($this->dateCreated)) {
            $qb->andWhere('date_created = :dateCreated');
            $qb->setParameter('dateCreated', $this->dateCreated->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateCreatedFrom)) {
            $qb->andWhere('date_created >= :dateCreatedFrom');
            $qb->setParameter('dateCreatedFrom', $this->dateCreatedFrom->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateCreatedTo)) {
            $qb->andWhere('date_created <= :dateCreatedTo');
            $qb->setParameter('dateCreatedTo', $this->dateCreatedTo->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateModified)) {
            $qb->andWhere('date_modified = :dateModified');
            $qb->setParameter('dateModified', $this->dateModified->format('Y-m-d H:i:s'));
        }


        if (isset($this->dateModifiedFrom)) {
            $qb->andWhere('date_modified >= :dateModifiedFrom');
            $qb->setParameter('dateModifiedFrom', $this->dateModifiedFrom->format('Y-m-d H:i:s'));
        }

        if (isset($this->dateModifiedTo)) {
            $qb->andWhere('date_modified <= :dateModifiedTo');
            $qb->setParameter('dateModifiedTo', $this->dateModifiedTo->format('Y-m-d H:i:s'));
        }

        if (isset($this->sortDateCreatedASC)) {
            $qb->addOrderBy('date_created', $this->sortDateCreatedASC ? 'ASC' : 'DESC');
        }

        if (isset($this->sortDateModifiedASC)) {
            $qb->addOrderBy('date_modified', $this->sortDateModifiedASC ? 'ASC' : 'DESC');
        }
    }
}
