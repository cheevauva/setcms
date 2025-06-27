<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\Servant\CronSchedulerCreateServant;
use SetCMS\Module\CronScheduler\View\CronSchedulerPrivateCreateView;

class CronSchedulerPrivateCreateController extends ControllerViaPSR7
{

    protected CronSchedulerEntity $cronScheduler;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerCreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('cronScheduler')->notEmpty()->validate();

        $dateStart = $validation->string('cronScheduler.dateStart')->val();
        $dateEnd = $validation->string('cronScheduler.dateEnd')->val();

        $this->cronScheduler = new CronSchedulerEntity();
        $this->cronScheduler->id = $validation->uuid('cronScheduler.id')->val();
        $this->cronScheduler->job = $validation->string('cronScheduler.job')->notEmpty()->val();
        $this->cronScheduler->cronExpression = $validation->string('cronScheduler.cronExpression')->notEmpty()->val();
        $this->cronScheduler->dateStart = $dateStart ? new \DateTimeImmutable($dateStart) : null;
        $this->cronScheduler->dateEnd = $dateEnd ? new \DateTimeImmutable($dateEnd) : null;
        $this->cronScheduler->isActive = $validation->bool('cronScheduler.isActive')->val();
        $this->cronScheduler->isSafeRun = $validation->bool('cronScheduler.isSafeRun')->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerCreateServant) {
            $object->cronScheduler = $this->cronScheduler;
        }

        if ($object instanceof CronSchedulerPrivateCreateView) {
            $object->cronScheduler = $this->cronScheduler;
        }
    }
}
