<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Ordinary\OrdinaryEntity;
use SetCMS\Module\Posts\Post;
use SetCMS\Module\Posts\PostException;

class PostDAO extends OrdinaryDAO
{

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

    protected function getException(): PostException
    {
        return new PostException;
    }

    public function getBySlug(string $slug): Post
    {
        $qb = $this->dbal()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->getTableName(), 't');
        $qb->andWhere('t.slug = :slug');
        $qb->setParameter('slug', $slug);
        $qb->setMaxResults(1);

        $row = $qb->fetchAssociative();

        if (empty($row)) {
            throw $this->getException()::notFound();
        }

        return $this->record2entity($row);
    }

}
