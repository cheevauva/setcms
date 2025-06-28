<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\DAO;

use SetCMS\Module\CronScheduler\VO\CronSchedulerJobVO;

class CronSchedulerJobRetrieveManyDAO extends \UUA\DAO
{

    use \UUA\Traits\ContainerTrait;

    /**
     * @var CronSchedulerJobVO[]
     */
    public array $jobs;

    #[\Override]
    public function serve(): void
    {
        $jobs = require $this->container->get('basePath') . '/resources/jobs.php';

        $this->jobs = [];

        foreach ($jobs as $className => $meta) {
            $job = new CronSchedulerJobVO();
            $job->name = $meta[0];
            $job->label = $meta[1] ?? $meta[0];
            $job->className = $className;
            
            $this->jobs[] = $job;
        }
    }
}
