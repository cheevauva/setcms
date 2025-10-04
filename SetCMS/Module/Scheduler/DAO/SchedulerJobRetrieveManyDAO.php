<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\DAO;

use SetCMS\Module\Scheduler\VO\SchedulerJobVO;

class SchedulerJobRetrieveManyDAO extends \UUA\DAO
{

    use \UUA\Traits\ContainerTrait;

    public string $name;

    /**
     * @var SchedulerJobVO[]
     */
    public array $jobs;
    public ?SchedulerJobVO $job = null;

    #[\Override]
    public function serve(): void
    {
        $jobs = require $this->container->get('rootPath') . '/resources/jobs.php';

        $this->jobs = [];

        foreach ($jobs as $className => $meta) {
            $job = new SchedulerJobVO();
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
