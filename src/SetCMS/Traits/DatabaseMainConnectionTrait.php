<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SetCMS\Application\Database\DatabaseMainConnection;
use Doctrine\DBAL\Connection;

trait DatabaseMainConnectionTrait
{
    use \UUA\Traits\ContainerTrait;

    protected function db(): Connection
    {
        return DatabaseMainConnection::singleton($this->container)->getConnection();
    }
}
