<?php

declare(strict_types=1);

namespace SetCMS\Application\Database;

use SetCMS\Application\Database\DatabaseMainConnection;

trait DatabaseMainConnectionTrait
{

    use \SetCMS\Traits\DITrait;

    protected function db(): DatabaseMainConnection
    {
        return $this->container->get(DatabaseMainConnection::class);
    }

}
