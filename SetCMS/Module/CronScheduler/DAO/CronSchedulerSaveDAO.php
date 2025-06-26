<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;

class CronSchedulerSaveDAO extends EntitySaveDAO
{

    use CronSchedulerCommonDAO;

    public CronSchedulerEntity $cronScheduler;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->cronScheduler;

        parent::serve();
    }
}
