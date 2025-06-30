<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\DAO;

use SetCMS\Module\CronScheduler\VO\CronSchedulerJobVO;

class CronSchedulerJobRetrieveManyDAO extends \UUA\DAO
{

    use \UUA\Traits\ContainerTrait;

    public string $name;

    /**
     * @var CronSchedulerJobVO[]
     */
    public array $jobs;
    public ?CronSchedulerJobVO $job = null;

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
            
            if (isset($this->name) && $job->name !== $this->name) {
                continue;
            }

            $this->jobs[] = $job;
        }
        
        $this->job = $this->jobs[0] ?? null;
    }
}
