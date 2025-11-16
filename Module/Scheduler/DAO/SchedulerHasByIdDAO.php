<?php

declare(strict_types=1);

namespace Module\Scheduler\DAO;

use SetCMS\Common\DAO\EntityHasByIdDAO;

class SchedulerHasByIdDAO extends EntityHasByIdDAO
{

    use SchedulerCommonDAO;
}
