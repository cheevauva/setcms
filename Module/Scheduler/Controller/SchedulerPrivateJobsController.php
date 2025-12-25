<?php

declare(strict_types=1);

namespace Module\Scheduler\Controller;

use SetCMS\Controller\ControllerViaEmbedded;
use Module\Scheduler\DAO\SchedulerJobRetrieveManyDAO;
use Module\Scheduler\VO\SchedulerJobVO;

class SchedulerPrivateJobsController extends ControllerViaEmbedded
{

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerJobRetrieveManyDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerJobRetrieveManyDAO) {
            foreach ($object->jobs as $job) {
                $job = SchedulerJobVO::as($job);

                $this->embedded[$job->name] = $job->label;
            }
        }
    }

    #[\Override]
    protected function process(): void
    {
        
    }
}
