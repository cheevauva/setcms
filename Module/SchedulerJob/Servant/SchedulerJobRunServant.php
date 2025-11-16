<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Servant;

use SetCMS\UUID;
use Module\Scheduler\DAO\SchedulerRetrieveManyByCriteriaDAO;
use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use Module\Scheduler\Entity\SchedulerEntity;
use Module\Scheduler\DAO\SchedulerJobRetrieveManyDAO;
use Module\Scheduler\VO\SchedulerJobVO;
use UUA\Servant;
use UUA\Unit;

class SchedulerJobRunServant extends Servant
{

    public UUID $schedulerId;
    public SchedulerJobEntity $schedulerJob;

    #[\Override]
    public function serve(): void
    {
        $cronSchedulerById = SchedulerRetrieveManyByCriteriaDAO::new($this->container);
        $cronSchedulerById->id = $this->schedulerId;
        $cronSchedulerById->serve();

        $scheduler = SchedulerEntity::as($cronSchedulerById->scheduler);

        $work = new SchedulerJobEntity();
        $work->schedulerId = $scheduler->id;
        $work->start();
        
        $this->schedulerJob = $work;
        $this->save($work);

        $jobByName = SchedulerJobRetrieveManyDAO::new($this->container);
        $jobByName->name = $scheduler->job;
        $jobByName->serve();

        $job = SchedulerJobVO::as($jobByName->job);

        try {
            $servant = Unit::as($job->className::new($this->container));
            $servant->serve();

            $work->end();
        } catch (\Throwable $ex) {
            $work->error($ex->getMessage());

            throw $ex;
        } finally {
            $this->save($work);
        }
    }

    protected function save(SchedulerJobEntity $work): void
    {
        $saveWork = SchedulerJobSaveDAO::new($this->container);
        $saveWork->schedulerJob = $work;
        $saveWork->serve();
    }
}
