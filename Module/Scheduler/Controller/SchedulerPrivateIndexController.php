<?php

declare(strict_types=1);

namespace Module\Scheduler\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Scheduler\DAO\SchedulerRetrieveManyByCriteriaDAO;
use Module\Scheduler\View\SchedulerPrivateIndexView;
use Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var SchedulerEntity[]
     */
    protected array $schedulers = [];

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
            SchedulerPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerRetrieveManyByCriteriaDAO) {
            $this->schedulers = $object->schedulers;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof SchedulerPrivateIndexView) {
            $object->schedulers = $this->schedulers;
        }
    }
}
