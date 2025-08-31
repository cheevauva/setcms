<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronSchedulerWork\Servant\CronSchedulerWorkUpdateServant;
use SetCMS\Module\CronSchedulerWork\View\CronSchedulerWorkPrivateUpdateView;

class CronSchedulerWorkPrivateUpdateController extends ControllerViaPSR7
{

    protected CronSchedulerWorkEntity $cronSchedulerWork;
    protected CronSchedulerWorkEntity $newcronSchedulerWork;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerWorkRetrieveManyByCriteriaDAO::class,
            CronSchedulerWorkUpdateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerWorkPrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newcronSchedulerWork = new CronSchedulerWorkEntity;
        $this->newcronSchedulerWork->id = $validation->uuid('cronSchedulerWork.id')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerWorkRetrieveManyByCriteriaDAO) {
            $object->id = $this->newcronSchedulerWork->id;
            $object->orThrow = true;
        }

        if ($object instanceof CronSchedulerWorkUpdateServant) {
            $object->cronSchedulerWork = $this->cronSchedulerWork;
        }

        if ($object instanceof CronSchedulerWorkPrivateUpdateView) {
            $object->cronSchedulerWork = $this->cronSchedulerWork ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerWorkRetrieveManyByCriteriaDAO) {
            $this->cronSchedulerWork = CronSchedulerWorkEntity::as($object->cronSchedulerWork);
            $this->cronSchedulerWork->status = $this->newcronSchedulerWork->status;
        }
    }
}
