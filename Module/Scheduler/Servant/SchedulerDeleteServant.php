<?php

declare(strict_types=1);

namespace Module\Scheduler\Servant;

use SetCMS\UUID;
use Module\Scheduler\Entity\SchedulerEntity;
use Module\Scheduler\DAO\SchedulerRetrieveManyByCriteriaDAO;
use Module\Scheduler\DAO\SchedulerSaveDAO;
use Module\Scheduler\Exception\SchedulerNotFoundException;

class SchedulerDeleteServant extends \UUA\Servant
{

    public ?SchedulerEntity $scheduler = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $schedulerById = SchedulerRetrieveManyByCriteriaDAO::new($this->container);
        $schedulerById->id = $this->id ?? ($this->scheduler->id ?? throw new \RuntimeException('id is undefined'));
        $schedulerById->serve();

        if (!$schedulerById->scheduler) {
            throw new SchedulerNotFoundException;
        }

        $scheduler = SchedulerEntity::as($schedulerById->scheduler);
        $scheduler->deleted = true;

        $save = SchedulerSaveDAO::new($this->container);
        $save->scheduler = $scheduler;
        $save->serve();

        $this->scheduler = $scheduler;
    }
}
