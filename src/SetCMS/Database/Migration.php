<?php

namespace SetCMS\Database;

abstract class Migration
{

    protected ConnectionFactory $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    abstract public function dbal(): \Doctrine\DBAL\Connection;
    abstract public function up(): void;
}
