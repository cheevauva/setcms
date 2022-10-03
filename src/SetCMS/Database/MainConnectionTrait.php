<?php

declare(strict_types=1);

namespace SetCMS\Database;

use SetCMS\Database\MainConnection;

trait MainConnectionTrait
{

    use \SetCMS\DITrait;

    protected function db(): MainConnection
    {
        return $this->container->get(MainConnection::class);
    }

}
