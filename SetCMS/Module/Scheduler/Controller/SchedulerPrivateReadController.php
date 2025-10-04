<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Scheduler\Entity\SchedulerEntity;
use SetCMS\Module\Scheduler\DAO\SchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\Scheduler\View\SchedulerPrivateReadView;
use SetCMS\Application\Router\RouterMatchDTO;

class SchedulerPrivateReadController extends ControllerViaPSR7
{

    protected SchedulerEntity $scheduler;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerPrivateReadView::class,
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

        if ($object instanceof SchedulerRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof SchedulerPrivateReadView) {
            $object->scheduler = $this->scheduler;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerRetrieveManyByCriteriaDAO) {
            $this->scheduler = SchedulerEntity::as($object->scheduler);
        }
    }
}
