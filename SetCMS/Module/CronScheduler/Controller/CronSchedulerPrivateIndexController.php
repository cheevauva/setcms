<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronScheduler\DAO\CronSchedulerRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronScheduler\View\CronSchedulerPrivateIndexView;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;

class CronSchedulerPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var CronSchedulerEntity[]
     */
    protected array $cronSchedulers = [];

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
            CronSchedulerPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerRetrieveManyByCriteriaDAO) {
            $this->cronSchedulers = $object->cronSchedulers;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof CronSchedulerPrivateIndexView) {
            $object->cronSchedulers = $this->cronSchedulers;
        }
    }
}
