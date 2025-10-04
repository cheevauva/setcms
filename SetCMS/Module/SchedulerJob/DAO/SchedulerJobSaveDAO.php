<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobSaveDAO extends EntitySaveDAO
{

    use SchedulerJobCommonDAO;

    public SchedulerJobEntity $schedulerJob;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->schedulerJob;

        parent::serve();
    }
}
