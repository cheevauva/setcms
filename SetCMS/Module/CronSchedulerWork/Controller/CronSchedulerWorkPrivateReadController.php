<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronSchedulerWork\View\CronSchedulerWorkPrivateReadView;
use SetCMS\Application\Router\RouterMatchDTO;

class CronSchedulerWorkPrivateReadController extends ControllerViaPSR7
{

    protected CronSchedulerWorkEntity $cronSchedulerWork;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerWorkRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerWorkPrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation(RouterMatchDTO::as($this->ctx['routerMatch'])->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerWorkRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof CronSchedulerWorkPrivateReadView) {
            $object->cronSchedulerWork = $this->cronSchedulerWork;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerWorkRetrieveManyByCriteriaDAO) {
            $this->cronSchedulerWork = CronSchedulerWorkEntity::as($object->cronSchedulerWork);
        }
    }
}
