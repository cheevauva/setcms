<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronSchedulerWork\Servant\CronSchedulerWorkRunServant;
use SetCMS\UUID;

class CronSchedulerRunController extends ControllerViaPSR7
{

    public UUID $cronSchedulerId;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerWorkRunServant::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getQueryParams());

        $this->cronSchedulerId = $validation->uuid('cronSchedulerId')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerWorkRunServant) {
            $object->cronSchedulerId = $this->cronSchedulerId;
        }
    }
}
