<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;
use Psr\Container\ContainerInterface;

class PostCreateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityCreateDAOTrait;
    use PostCommonDAO;

    public PostEntity $post;

    #[\Override]
    protected function row(): array
    {
        return PostToRowMapper::call($this->container, $this->post)->row;
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
