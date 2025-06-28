<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\ControllerViaEmbedded;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerJobRetrieveManyDAO;
use SetCMS\Module\CronScheduler\VO\CronSchedulerJobVO;

class CronSchedulerPrivateJobsController extends ControllerViaEmbedded
{

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerJobRetrieveManyDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerJobRetrieveManyDAO) {
            foreach ($object->jobs as $job) {
                $job = CronSchedulerJobVO::as($job);

                $this->embedded[$job->name] = $job->label;
            }
        }
    }
}
