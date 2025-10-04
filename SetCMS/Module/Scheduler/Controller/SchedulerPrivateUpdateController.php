<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Scheduler\Entity\SchedulerEntity;
use SetCMS\Module\Scheduler\DAO\SchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\Scheduler\Servant\SchedulerUpdateServant;
use SetCMS\Module\Scheduler\View\SchedulerPrivateUpdateView;

class SchedulerPrivateUpdateController extends ControllerViaPSR7
{

    protected SchedulerEntity $scheduler;
    protected SchedulerEntity $newScheduler;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerRetrieveManyByCriteriaDAO::class,
            SchedulerUpdateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerPrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newScheduler = new SchedulerEntity;
        $this->newScheduler->id = $validation->uuid('scheduler.id')->notEmpty()->val();
        $this->newScheduler->job = $validation->string('scheduler.job')->notEmpty()->val();

        $dateStart = $validation->string('scheduler.dateStart')->val();
        $dateEnd = $validation->string('scheduler.dateEnd')->val();

        $this->newScheduler->cronExpression = $validation->string('scheduler.cronExpression')->notEmpty()->val();
        $this->newScheduler->dateStart = $dateStart ? new \DateTimeImmutable($dateStart) : null;
        $this->newScheduler->dateEnd = $dateEnd ? new \DateTimeImmutable($dateEnd) : null;
        $this->newScheduler->isActive = $validation->bool('scheduler.isActive')->val();
        $this->newScheduler->isSafeRun = $validation->bool('scheduler.isSafeRun')->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerRetrieveManyByCriteriaDAO) {
            $object->id = $this->newScheduler->id;
            $object->orThrow = true;
        }

        if ($object instanceof SchedulerUpdateServant) {
            $object->scheduler = $this->scheduler;
        }

        if ($object instanceof SchedulerPrivateUpdateView) {
            $object->scheduler = $this->scheduler ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerRetrieveManyByCriteriaDAO) {
            $this->scheduler = SchedulerEntity::as($object->scheduler);
            $this->scheduler->job = $this->newScheduler->job;
            $this->scheduler->dateStart = $this->newScheduler->dateStart;
            $this->scheduler->dateEnd = $this->newScheduler->dateEnd;
            $this->scheduler->cronExpression = $this->newScheduler->cronExpression;
            $this->scheduler->isActive = $this->newScheduler->isActive;
            $this->scheduler->isSafeRun = $this->newScheduler->isSafeRun;
        }
    }
}
