<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Servant;

use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\DAO\SchedulerJobHasByIdDAO;
use Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use Module\SchedulerJob\Exception\SchedulerJobAlreadyExistsException;

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
