<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Post\Entity\PostEntity;
use Module\Post\Exception\PostExpectOneButReceivedTooMuchException;
use Module\Post\Exception\PostNotFoundException;
use Module\Post\Exception\PostsNotFoundException;
use Module\Post\Mapper\PostFromRowMapper;

class PostRetrieveManyByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityRetrieveByCriteriaDAOTrait;
    use PostCommonDAO;

    public string $slug;

    /**
     * @var array<PostEntity>
     */
    public protected(set) array $posts;
    public protected(set) PostEntity $post;
    public protected(set) ?PostEntity $postOrNull;

    #[\Override]
    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        if (isset($this->slug)) {
            $qb->andWhere('slug = :slug');
            $qb->setParameter('slug', $this->slug);
        }

        return $qb;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new PostsNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new PostExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new PostNotFoundException;
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->posts = array_map(fn($row) => PostFromRowMapper::call($this->container, $row)->post, $rows);

        if (isset($this->posts[0])) {
            $this->post = $this->postOrNull = $this->posts[0];
        }
    }
}
