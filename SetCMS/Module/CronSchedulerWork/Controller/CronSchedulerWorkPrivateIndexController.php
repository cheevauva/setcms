<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronSchedulerWork\DAO\CronSchedulerWorkRetrieveManyByCriteriaDAO;
use SetCMS\Module\CronSchedulerWork\View\CronSchedulerWorkPrivateIndexView;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;

class CronSchedulerWorkPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var CronSchedulerWorkEntity[]
     */
    protected array $cronSchedulerWorks = [];

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
            CronSchedulerWorkPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CronSchedulerWorkRetrieveManyByCriteriaDAO) {
            $this->cronSchedulerWorks = $object->cronSchedulerWorks;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof CronSchedulerWorkPrivateIndexView) {
            $object->cronSchedulerWorks = $this->cronSchedulerWorks;
        }
    }
}
