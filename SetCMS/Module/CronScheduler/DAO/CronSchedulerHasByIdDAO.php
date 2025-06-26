<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\DAO;

use SetCMS\Common\DAO\EntityHasByIdDAO;

class CronSchedulerHasByIdDAO extends EntityHasByIdDAO
{

    use CronSchedulerCommonDAO;
}
