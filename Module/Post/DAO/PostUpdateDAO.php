<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Psr\Container\ContainerInterface;
use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;

class PostUpdateDAO extends \UUA\DAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;
    use \SetCMS\DAO\EntityUpdateDAOTrait;

    public PostEntity $post;

    #[\Override]
    protected function row(): array
    {
        return PostToRowMapper::call($this->container, $this->post)->row;
    }

    #[\Override]
    protected function id(): string
    {
        return (string) $this->post->id;
    }

    /**
     * @param ContainerInterface $container
     * @param PostEntity $post
     * @return static
     */
    public static function call(ContainerInterface $container, PostEntity $post): self
    {
        $self = self::new($container);
        $self->post = $post;
        $self->serve();

        return $self;
    }
}
