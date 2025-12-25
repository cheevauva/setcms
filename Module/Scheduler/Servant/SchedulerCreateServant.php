<?php

declare(strict_types=1);

namespace Module\Scheduler\Servant;

use Module\Scheduler\Entity\SchedulerEntity;
use Module\Scheduler\DAO\SchedulerHasByIdDAO;
use Module\Scheduler\DAO\SchedulerSaveDAO;
use Module\Scheduler\Exception\SchedulerAlreadyExistsException;

class SchedulerCreateServant extends \UUA\Servant
{

    public SchedulerEntity $scheduler;

    #[\Override]
    public function serve(): void
    {
        $hasEntityById = SchedulerHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->scheduler->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new SchedulerAlreadyExistsException;
        }

        $saveEntity = SchedulerSaveDAO::new($this->container);
        $saveEntity->scheduler = $this->scheduler;
        $saveEntity->serve();
    }
}
