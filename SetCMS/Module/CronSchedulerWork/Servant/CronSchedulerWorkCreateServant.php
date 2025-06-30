<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Servant;

use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkHasByIdDAO;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkSaveDAO;
use SetCMS\Module\CronSchedulerWork\Exception\CronSchedulerWorkAlreadyExistsException;

class CronSchedulerWorkCreateServant extends \UUA\Servant
{

    public CronSchedulerWorkEntity $cronSchedulerWork;

    #[\Override]
    public function serve(): void
    {
        $hasEntityById = CronSchedulerWorkHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->cronSchedulerWork->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new CronSchedulerWorkAlreadyExistsException;
        }

        $saveEntity = CronSchedulerWorkSaveDAO::new($this->container);
        $saveEntity->cronSchedulerWork = $this->cronSchedulerWork;
        $saveEntity->serve();
    }
}
