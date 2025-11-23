<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use UUA\DAO;
use SetCMS\Database\Database;
use SetCMS\Database\DatabaseQueryBuilder;

abstract class SQLCommonDAO extends DAO
{

    abstract protected function db(): Database;

    abstract protected function table(): string;

    abstract protected function createQuery(): DatabaseQueryBuilder;
}
