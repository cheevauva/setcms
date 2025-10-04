<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\DAO;

use SetCMS\Module\Scheduler\Entity\SchedulerEntity;
use SetCMS\Module\Scheduler\Exception\SchedulerNotFoundException;

class SchedulerRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use SchedulerCommonDAO;

    /**
     * @var array<SchedulerEntity>
     */
    public array $schedulers;
    public ?SchedulerEntity $scheduler;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->schedulers = SchedulerEntity::manyAs($this->entities);
        $this->scheduler = $this->first ? SchedulerEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new SchedulerNotFoundException();
    }
}
