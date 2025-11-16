<?php

declare(strict_types=1);

namespace Module\Scheduler\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Scheduler\Entity\SchedulerEntity;
use Module\Scheduler\Servant\SchedulerCreateServant;
use Module\Scheduler\View\SchedulerPrivateCreateView;

class SchedulerPrivateCreateController extends ControllerViaPSR7
{

    protected SchedulerEntity $scheduler;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerCreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('scheduler')->notEmpty()->validate();

        $dateStart = $validation->string('scheduler.dateStart')->val();
        $dateEnd = $validation->string('scheduler.dateEnd')->val();

        $this->scheduler = new SchedulerEntity();
        $this->scheduler->id = $validation->uuid('scheduler.id')->val();
        $this->scheduler->job = $validation->string('scheduler.job')->notEmpty()->val();
        $this->scheduler->cronExpression = $validation->string('scheduler.cronExpression')->notEmpty()->val();
        $this->scheduler->dateStart = $dateStart ? new \DateTimeImmutable($dateStart) : null;
        $this->scheduler->dateEnd = $dateEnd ? new \DateTimeImmutable($dateEnd) : null;
        $this->scheduler->isActive = $validation->bool('scheduler.isActive')->val();
        $this->scheduler->isSafeRun = $validation->bool('scheduler.isSafeRun')->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerCreateServant) {
            $object->scheduler = $this->scheduler;
        }

        if ($object instanceof SchedulerPrivateCreateView) {
            $object->scheduler = $this->scheduler;
        }
    }
}
