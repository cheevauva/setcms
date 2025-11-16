<?php

declare(strict_types=1);

namespace Module\Scheduler\Servant;

use Module\Scheduler\Entity\SchedulerEntity;
use Module\Scheduler\DAO\SchedulerHasByIdDAO;
use Module\Scheduler\DAO\SchedulerSaveDAO;
use Module\Scheduler\Exception\SchedulerNotFoundException;

class SchedulerUpdateServant extends \UUA\Servant
{

    public SchedulerEntity $scheduler;

    #[\Override]
    public function serve(): void
    {
        $hasById = SchedulerHasByIdDAO::new($this->container);
        $hasById->id = $this->scheduler->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new SchedulerNotFoundException;
        }

        $saveEntity = SchedulerSaveDAO::new($this->container);
        $saveEntity->scheduler = $this->scheduler;
        $saveEntity->serve();
    }
}
