<?php

namespace SetCMS\Module\Migrations\Migration;

use SetCMS\Database\ConnectionFactory;

trait MigrationDBALTrait
{

    protected ConnectionFactory $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    abstract protected function dbal(): \Doctrine\DBAL\Connection;
}
