<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Servant;

use SetCMS\UUID;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkSaveDAO;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerJobRetrieveManyDAO;
use SetCMS\Module\CronScheduler\VO\CronSchedulerJobVO;
use UUA\Servant;

class CronSchedulerWorkRunServant extends Servant
{

    public UUID $cronSchedulerId;
    public CronSchedulerWorkEntity $cronSchedulerWork;

    #[\Override]
    public function serve(): void
    {
        $retriveById = CronSchedulerRetrieveManyByCriteriaDAO::new($this->container);
        $retriveById->id = $this->cronSchedulerId;
        $retriveById->serve();

        $cronScheduler = CronSchedulerEntity::as($retriveById->cronScheduler);

        $work = $this->cronSchedulerWork = new CronSchedulerWorkEntity();
        $work->cronSchedulerId = $cronScheduler->id;
        $work->start();

        $this->save($work);

        $retriveJob = CronSchedulerJobRetrieveManyDAO::new($this->container);
        $retriveJob->name = $cronScheduler->job;
        $retriveJob->serve();

        $job = CronSchedulerJobVO::as($retriveJob->job);

        try {
            $servant = Servant::as($job->className::new($this->container));
            $servant->serve();

            $work->end();
        } catch (\Throwable $ex) {
            $work->error($ex->getMessage());

            throw $ex;
        } finally {
            $this->save($work);
        }
    }

    protected function save(CronSchedulerWorkEntity $work): void
    {
        $saveWork = CronSchedulerWorkSaveDAO::new($this->container);
        $saveWork->cronSchedulerWork = $work;
        $saveWork->serve();
    }
}
