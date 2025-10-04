<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\Servant;

use SetCMS\Module\Scheduler\Entity\SchedulerEntity;
use SetCMS\Module\Scheduler\DAO\SchedulerHasByIdDAO;
use SetCMS\Module\Scheduler\DAO\SchedulerSaveDAO;
use SetCMS\Module\Scheduler\Exception\SchedulerAlreadyExistsException;

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
