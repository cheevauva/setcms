<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;

class CronSchedulerWorkSaveDAO extends EntitySaveDAO
{

    use CronSchedulerWorkCommonDAO;

    public CronSchedulerWorkEntity $cronSchedulerWork;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->cronSchedulerWork;

        parent::serve();
    }
}
