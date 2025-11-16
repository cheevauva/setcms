<?php

declare(strict_types=1);

namespace Module\SchedulerJob\DAO;

use SetCMS\Common\DAO\EntityHasByIdDAO;

class SchedulerJobHasByIdDAO extends EntityHasByIdDAO
{

    use SchedulerJobCommonDAO;
}
