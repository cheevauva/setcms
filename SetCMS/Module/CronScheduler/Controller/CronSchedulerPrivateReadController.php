<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronScheduler\View\CronSchedulerPrivateReadView;
use SetCMS\Application\Router\RouterMatchDTO;

class CronSchedulerPrivateReadController extends ControllerViaPSR7
{

    protected CronSchedulerEntity $cronScheduler;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerPrivateReadView::class,
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

        if ($object instanceof CronSchedulerRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof CronSchedulerPrivateReadView) {
            $object->cronScheduler = $this->cronScheduler;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerRetrieveManyByCriteriaDAO) {
            $this->cronScheduler = CronSchedulerEntity::as($object->cronScheduler);
        }
    }
}
