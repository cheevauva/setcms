<?php

namespace SetCMS\Module\Migrations\Migration;

use Doctrine\DBAL\Schema\Table;
use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Posts\PostService;

class Migration1633807960 implements MigrationInterface
{

    use MigrationDBALTrait;

    private PostService $postService;

    public function __construct(\SetCMS\Database\ConnectionFactory $connectionFactory, PostService $postService)
    {
        $this->connectionFactory = $connectionFactory;
        $this->postService = $postService;
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('posts')) {
            return;
        }

        $table = new Table('posts');
        $table->addColumn('slug', 'string')->setLength(255);
        $table->addColumn('title', 'string')->setLength(255);
        $table->addColumn('message', 'text');
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addColumn('user_id', 'string')->setLength(36)->setNotnull(true)->setDefault(1);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);

        $this->postService->createFirstPost();
    }

    protected function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(PostDAO::class);
    }

    public function down(): void
    {
        $this->dbal()->createSchemaManager()->dropTable('posts');
    }

}
