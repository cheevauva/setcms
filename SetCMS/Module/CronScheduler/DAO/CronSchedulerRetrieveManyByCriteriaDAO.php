<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\DAO;

use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\Exception\CronSchedulerNotFoundException;

class CronSchedulerRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use CronSchedulerCommonDAO;

    /**
     * @var array<CronSchedulerEntity>
     */
    public array $cronSchedulers;
    public ?CronSchedulerEntity $cronScheduler;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->cronSchedulers = CronSchedulerEntity::manyAs($this->entities);
        $this->cronScheduler = $this->first ? CronSchedulerEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new CronSchedulerNotFoundException();
    }
}
