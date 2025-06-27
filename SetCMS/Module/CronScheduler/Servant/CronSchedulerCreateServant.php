<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Servant;

use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerHasByIdDAO;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerSaveDAO;
use SetCMS\Module\CronScheduler\Exception\CronSchedulerAlreadyExistsException;

class CronSchedulerCreateServant extends \UUA\Servant
{

    public CronSchedulerEntity $cronScheduler;

    #[\Override]
    public function serve(): void
    {
        $hasEntityById = CronSchedulerHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->cronScheduler->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new CronSchedulerAlreadyExistsException;
        }

        $saveEntity = CronSchedulerSaveDAO::new($this->container);
        $saveEntity->cronScheduler = $this->cronScheduler;
        $saveEntity->serve();
    }
}
