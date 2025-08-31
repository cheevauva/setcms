<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\DAO;

use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\Exception\CronSchedulerWorkNotFoundException;

class CronSchedulerWorkRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use CronSchedulerWorkCommonDAO;

    /**
     * @var array<CronSchedulerWorkEntity>
     */
    public array $cronSchedulerWorks;
    public ?CronSchedulerWorkEntity $cronSchedulerWork;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->cronSchedulerWorks = CronSchedulerWorkEntity::manyAs($this->entities);
        $this->cronSchedulerWork = $this->first ? CronSchedulerWorkEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new CronSchedulerWorkNotFoundException();
    }
}
