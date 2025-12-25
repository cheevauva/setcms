<?php

declare(strict_types=1);

namespace Module\Scheduler\DAO;

use SetCMS\DAO\EntitySaveDAO;
use Module\Scheduler\Entity\SchedulerEntity;

class SchedulerSaveDAO extends EntitySaveDAO
{

    use SchedulerCommonDAO;

    public SchedulerEntity $scheduler;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->scheduler;

        parent::serve();
    }
}
