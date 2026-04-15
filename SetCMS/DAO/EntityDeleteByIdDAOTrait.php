<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;
use Psr\Container\ContainerInterface;

trait EntityDeleteByIdDAOTrait
{
    use \UUA\Traits\AsTrait;

    public UUID $id;

    public function serve(): void
    {
        $this->createQuery()->executeQuery();
    }

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();
        $qb->delete($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $this->id->uuid);
        $qb->setMaxResults(1);

        return $qb;
    }

    /**
     * @param ContainerInterface $container
     * @param UUID $id
     * @return static
     */
    public static function call(ContainerInterface $container, UUID $id): self
    {
        $self = self::new($container);
        $self->id = $id;
        $self->serve();

        return $self;
    }
}
