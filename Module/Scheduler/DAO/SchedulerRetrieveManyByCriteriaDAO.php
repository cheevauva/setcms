<?php

declare(strict_types=1);

namespace Module\Scheduler\DAO;

use Module\Scheduler\Entity\SchedulerEntity;
use Module\Scheduler\Exception\SchedulerNotFoundException;
use SetCMS\Database\DatabaseQueryBuilder;

class SchedulerRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use SchedulerCommonDAO;

    /**
     * @var array<SchedulerEntity>
     */
    public array $schedulers;
    public ?SchedulerEntity $scheduler;
    public bool $isActive;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->schedulers = SchedulerEntity::manyAs($this->entities);
        $this->scheduler = $this->first ? SchedulerEntity::as($this->first) : null;
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = parent::createQuery();

        if (isset($this->isActive)) {
            $qb->andWhere('is_active  = :isActive');
            $qb->setParameter('isActive', $this->isActive);
        }

        return $qb;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new SchedulerNotFoundException();
    }
}
