<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Servant;

use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerHasByIdDAO;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerSaveDAO;
use SetCMS\Module\CronScheduler\Exception\CronSchedulerNotFoundException;

class CronSchedulerUpdateServant extends \UUA\Servant
{

    public CronSchedulerEntity $cronScheduler;

    #[\Override]
    public function serve(): void
    {
        $hasById = CronSchedulerHasByIdDAO::new($this->container);
        $hasById->id = $this->cronScheduler->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new CronSchedulerNotFoundException;
        }

        $saveEntity = CronSchedulerSaveDAO::new($this->container);
        $saveEntity->cronScheduler = $this->cronScheduler;
        $saveEntity->serve();
    }
}
