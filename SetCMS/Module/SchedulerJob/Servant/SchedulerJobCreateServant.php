<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\Servant;

use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobHasByIdDAO;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use SetCMS\Module\SchedulerJob\Exception\SchedulerJobAlreadyExistsException;

class SchedulerJobCreateServant extends \UUA\Servant
{

    public SchedulerJobEntity $schedulerJob;

    #[\Override]
    public function serve(): void
    {
        $hasEntityById = SchedulerJobHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->schedulerJob->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new SchedulerJobAlreadyExistsException;
        }

        $saveEntity = SchedulerJobSaveDAO::new($this->container);
        $saveEntity->schedulerJob = $this->schedulerJob;
        $saveEntity->serve();
    }
}
