<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Servant;

use SetCMS\UUID;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerSaveDAO;
use SetCMS\Module\CronScheduler\Exception\CronSchedulerNotFoundException;

class CronSchedulerDeleteServant extends \UUA\Servant
{

    public ?CronSchedulerEntity $cronScheduler = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $cronSchedulerById = CronSchedulerRetrieveManyByCriteriaDAO::new($this->container);
        $cronSchedulerById->id = $this->id ?? ($this->cronScheduler->id ?? throw new \RuntimeException('id is undefined'));
        $cronSchedulerById->serve();

        if (!$cronSchedulerById->cronScheduler) {
            throw new CronSchedulerNotFoundException;
        }

        $cronScheduler = CronSchedulerEntity::as($cronSchedulerById->cronScheduler);
        $cronScheduler->deleted = true;

        $save = CronSchedulerSaveDAO::new($this->container);
        $save->cronScheduler = $cronScheduler;
        $save->serve();

        $this->cronScheduler = $cronScheduler;
    }
}
