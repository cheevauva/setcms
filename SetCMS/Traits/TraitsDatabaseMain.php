<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SetCMS\Database\DatabaseFactory;
use SetCMS\Database\Database;

trait TraitsDatabaseMain
{

    use \UUA\Traits\ContainerTrait;

    protected function db(): Database
    {
        return DatabaseFactory::singleton($this->container)->make('main');
    }
}
