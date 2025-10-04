<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\DAO;

use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;
use SetCMS\Module\SchedulerJob\Exception\SchedulerJobNotFoundException;

class SchedulerJobRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use SchedulerJobCommonDAO;

    /**
     * @var array<SchedulerJobEntity>
     */
    public array $schedulerJobs;
    public ?SchedulerJobEntity $schedulerJob;

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
}
