<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Ordinary\OrdinaryEntity;
use SetCMS\Module\Posts\Post;
use SetCMS\Module\Posts\PostException;
use SetCMS\Module\Posts\PostDatabase;

class PostDAO extends OrdinaryDAO
{

    protected PostDatabase $db;

    public function __construct(PostDatabase $db)
    {
        $this->db = $db;
    }

    protected function entity2record(OrdinaryEntity $entity): array
    {
        assert($entity instanceof Post);

        $record = [
            'title' => $entity->title,
            'message' => $entity->message,
            'slug' => $entity->slug,
        ];

        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function getTableName(): string
    {
        return 'posts';
    }

    protected function record2entity(array $record): Post
    {
        $post = $this->ordinaryRecord2EntityBind($record, new Post);
        $post->slug = $record['slug'];
        $post->message = $record['message'];
        $post->title = $record['title'];

        return $post;
    }

    protected function getException(): \Exception
    {
        return new PostException;
    }

    public function getDatabase(): PostDatabase
    {
        return $this->db;
    }

}
