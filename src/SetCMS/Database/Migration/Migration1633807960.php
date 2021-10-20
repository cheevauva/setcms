<?php

namespace SetCMS\Database\Migration;

use Doctrine\DBAL\Schema\Table;
use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Posts\Post;

class Migration1633807960 extends \SetCMS\Database\Migration
{

    private PostDAO $postDAO;

    public function __construct(\SetCMS\Database\ConnectionFactory $connectionFactory, PostDAO $postDAO)
    {
        parent::__construct($connectionFactory);

        $this->postDAO = $postDAO;
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
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);

        $this->createFirstPost();
    }

    private function createFirstPost()
    {
        $post = new Post;
        $post->slug = 'hello_world';
        $post->title = 'SetCMS готова к использованию';
        $post->message = implode(PHP_EOL, [
            'Реквизиты администратора:',
            '',
            '- Пользователь:admin',
            '- Пароль: administrator',
            '',
            '*После входа обязательно смените пароль*',
        ]);

        $this->postDAO->save($post);
    }

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(PostDAO::class);
    }

}
