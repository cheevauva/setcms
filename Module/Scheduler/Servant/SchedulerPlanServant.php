<?php

declare(strict_types=1);

namespace Module\Scheduler\Servant;

use Module\Scheduler\DAO\SchedulerRetrieveManyByCriteriaDAO;
use Module\SchedulerJob\DAO\SchedulerJobRetrieveManyByCriteriaDAO;
use Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use Module\Scheduler\Entity\SchedulerEntity;
use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\Enum\SchedulerJobStatusEnum;

class SchedulerPlanServant extends \UUA\Servant
{

    #[\Override]
    public function serve(): void
    {
        $schedulersByCriteria = SchedulerRetrieveManyByCriteriaDAO::new($this->container);
        $schedulersByCriteria->isActive = true;
        $schedulersByCriteria->serve();

        foreach ($schedulersByCriteria->schedulers as $scheduler) {
            $scheduler = SchedulerEntity::as($scheduler);

            $schedulerJobsByCriteria = SchedulerJobRetrieveManyByCriteriaDAO::new($this->container);
            $schedulerJobsByCriteria->schedulerId = $scheduler->id;
            $schedulerJobsByCriteria->status = SchedulerJobStatusEnum::_New;
            $schedulerJobsByCriteria->serve();

            if ($schedulerJobsByCriteria->schedulerJob) {
                continue;
            }

            $schedulerJob = new SchedulerJobEntity;
            $schedulerJob->schedulerId = $scheduler->id;

            $schedulerJobSave = SchedulerJobSaveDAO::new($this->container);
            $schedulerJobSave->schedulerJob = $schedulerJob;
            $schedulerJobSave->serve();
        }
    }
}
