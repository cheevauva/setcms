<?php

declare(strict_types=1);

namespace Module\SchedulerJob\DAO;

use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\Exception\SchedulerJobNotFoundException;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\UUID;
use Module\SchedulerJob\Enum\SchedulerJobStatusEnum;

class SchedulerJobRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use SchedulerJobCommonDAO;

    /**
     * @var array<SchedulerJobEntity>
     */
    public array $schedulerJobs;
    public ?SchedulerJobEntity $schedulerJob;
    public UUID $schedulerId;
    public SchedulerJobStatusEnum $status;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->schedulerJobs = SchedulerJobEntity::manyAs($this->entities);
        $this->schedulerJob = $this->first ? SchedulerJobEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new SchedulerJobNotFoundException();
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $q = parent::createQuery();

        if (isset($this->schedulerId)) {
            $q->andWhere('scheduler_id = :schedulerId');
            $q->setParameter('schedulerId', $this->schedulerId->uuid);
        }

        if (isset($this->status)) {
            $q->andWhere('status = :status');
            $q->setParameter('status', $this->status->value);
        }

        return $q;
    }
}
