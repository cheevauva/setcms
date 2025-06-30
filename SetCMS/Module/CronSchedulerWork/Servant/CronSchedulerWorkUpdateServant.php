<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Servant;

use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkHasByIdDAO;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkSaveDAO;
use SetCMS\Module\CronSchedulerWork\Exception\CronSchedulerWorkNotFoundException;

class CronSchedulerWorkUpdateServant extends \UUA\Servant
{

    public CronSchedulerWorkEntity $cronSchedulerWork;

    #[\Override]
    public function serve(): void
    {
        $hasById = CronSchedulerWorkHasByIdDAO::new($this->container);
        $hasById->id = $this->cronSchedulerWork->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new CronSchedulerWorkNotFoundException;
        }

        $saveEntity = CronSchedulerWorkSaveDAO::new($this->container);
        $saveEntity->cronSchedulerWork = $this->cronSchedulerWork;
        $saveEntity->serve();
    }
}
