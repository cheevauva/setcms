<?php

declare(strict_types=1);

namespace Module\Scheduler\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\SchedulerJob\Servant\SchedulerJobRunServant;
use SetCMS\UUID;

class SchedulerRunController extends ControllerViaPSR7
{

    public UUID $schedulerId;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerJobRunServant::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getQueryParams());

        $this->schedulerId = $validation->uuid('schedulerId')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerJobRunServant) {
            $object->schedulerId = $this->schedulerId;
        }
    }
}
