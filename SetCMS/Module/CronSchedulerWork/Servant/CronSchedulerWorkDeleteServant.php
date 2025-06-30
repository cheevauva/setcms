<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Servant;

use SetCMS\UUID;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkSaveDAO;
use SetCMS\Module\CronSchedulerWork\Exception\CronSchedulerWorkNotFoundException;

class CronSchedulerWorkDeleteServant extends \UUA\Servant
{

    public ?CronSchedulerWorkEntity $cronSchedulerWork = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $cronSchedulerWorkById = CronSchedulerWorkRetrieveManyByCriteriaDAO::new($this->container);
        $cronSchedulerWorkById->id = $this->id ?? ($this->cronSchedulerWork->id ?? throw new \RuntimeException('id is undefined'));
        $cronSchedulerWorkById->serve();

        if (!$cronSchedulerWorkById->cronSchedulerWork) {
            throw new CronSchedulerWorkNotFoundException;
        }

        $cronSchedulerWork = CronSchedulerWorkEntity::as($cronSchedulerWorkById->cronSchedulerWork);
        $cronSchedulerWork->deleted = true;

        $save = CronSchedulerWorkSaveDAO::new($this->container);
        $save->cronSchedulerWork = $cronSchedulerWork;
        $save->serve();

        $this->cronSchedulerWork = $cronSchedulerWork;
    }
}
