<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronScheduler\Servant\CronSchedulerUpdateServant;
use SetCMS\Module\CronScheduler\View\CronSchedulerPrivateUpdateView;

class CronSchedulerPrivateUpdateController extends ControllerViaPSR7
{

    protected CronSchedulerEntity $cronScheduler;
    protected CronSchedulerEntity $newcronScheduler;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerRetrieveManyByCriteriaDAO::class,
            CronSchedulerUpdateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerPrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newcronScheduler = new CronSchedulerEntity;
        $this->newcronScheduler->id = $validation->uuid('cronScheduler.id')->notEmpty()->val();
        $this->newcronScheduler->job = $validation->string('cronScheduler.job')->notEmpty()->val();

        $dateStart = $validation->string('cronScheduler.dateStart')->val();
        $dateEnd = $validation->string('cronScheduler.dateEnd')->val();

        $this->newcronScheduler->cronExpression = $validation->string('cronScheduler.cronExpression')->notEmpty()->val();
        $this->newcronScheduler->dateStart = $dateStart ? new \DateTimeImmutable($dateStart) : null;
        $this->newcronScheduler->dateEnd = $dateEnd ? new \DateTimeImmutable($dateEnd) : null;
        $this->newcronScheduler->isActive = $validation->bool('cronScheduler.isActive')->val();
        $this->newcronScheduler->isSafeRun = $validation->bool('cronScheduler.isSafeRun')->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerRetrieveManyByCriteriaDAO) {
            $object->id = $this->newcronScheduler->id;
            $object->orThrow = true;
        }

        if ($object instanceof CronSchedulerUpdateServant) {
            $object->cronScheduler = $this->cronScheduler;
        }

        if ($object instanceof CronSchedulerPrivateUpdateView) {
            $object->cronScheduler = $this->cronScheduler ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerRetrieveManyByCriteriaDAO) {
            $this->cronScheduler = CronSchedulerEntity::as($object->cronScheduler);
            $this->cronScheduler->job = $this->newcronScheduler->job;
            $this->cronScheduler->dateStart = $this->newcronScheduler->dateStart;
            $this->cronScheduler->dateEnd = $this->newcronScheduler->dateEnd;
            $this->cronScheduler->cronExpression = $this->newcronScheduler->cronExpression;
            $this->cronScheduler->isActive = $this->newcronScheduler->isActive;
            $this->cronScheduler->isSafeRun = $this->newcronScheduler->isSafeRun;
        }
    }
}
