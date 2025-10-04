<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\Servant;

use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobHasByIdDAO;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use SetCMS\Module\SchedulerJob\Exception\SchedulerJobNotFoundException;

class SchedulerJobUpdateServant extends \UUA\Servant
{

    public SchedulerJobEntity $schedulerJob;

    #[\Override]
    public function serve(): void
    {
        $hasById = SchedulerJobHasByIdDAO::new($this->container);
        $hasById->id = $this->schedulerJob->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new SchedulerJobNotFoundException;
        }

        $saveEntity = SchedulerJobSaveDAO::new($this->container);
        $saveEntity->schedulerJob = $this->schedulerJob;
        $saveEntity->serve();
    }
}
