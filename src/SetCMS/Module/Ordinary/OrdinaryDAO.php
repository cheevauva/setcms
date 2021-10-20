<?php

namespace SetCMS\Module\Ordinary;

use SetCMS\Module\Ordinary\OrdinaryEntity;
use Doctrine\DBAL\Connection;
use SetCMS\Database\ConnectionFactory;

abstract class OrdinaryDAO
{

    protected ConnectionFactory $connectionFactory;
    private Connection $db;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    abstract protected function getTableName(): string;

    abstract protected function getException(): \Exception;

    protected function dbal(): Connection
    {
        if (empty($this->db)) {
            $this->db = $this->connectionFactory->get(get_class($this));
        }

        return $this->db;
    }

    public function list(int $offset = 0, $limit = 10, string $sort = 'id', string $order = ''): array
    {
        $qb = $this->dbal()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->getTableName(), 't');
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);
        $qb->addOrderBy($sort, $order);

        $posts = [];

        foreach ($qb->fetchAllAssociative() as $row) {
            $posts[] = $this->record2entity($row);
        }

        return $posts;
    }

    protected function getBy(array $criteria): OrdinaryEntity
    {
        $qb = $this->dbal()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->getTableName(), 't');
        $qb->setMaxResults(1);

        foreach ($criteria as $field => $value) {
            $qb->andWhere(sprintf('t.%s = :%s', $field, $field));
            $qb->setParameter($field, $value);
        }

        $row = $qb->fetchAssociative();

        if (empty($row)) {
            throw $this->getException()::notFound();
        }

        return $this->record2entity($row);
    }

    public function get(string $id): OrdinaryEntity
    {
        return $this->getBy(['id' => $id]);
    }

    public function remove(string $id): void
    {
        $this->dbal()->delete($this->getTableName(), ['id' => $id]);
    }

    public function has(string $id): bool
    {
        $qb = $this->dbal()->createQueryBuilder();
        $qb->select('id');
        $qb->from($this->getTableName());
        $qb->where('id = :id');
        $qb->setParameter('id', $id);

        return (bool) $qb->fetchOne();
    }

    public function save(OrdinaryEntity $entity): void
    {
        $db = $this->dbal();

        if (!$this->has($entity->id)) {
            $db->insert($this->getTableName(), $this->entity2record($entity));
        } else {
            $db->update($this->getTableName(), $this->entity2record($entity), ['id' => $entity->id]);
        }
    }

    protected function ordinaryEntity2RecordBind(OrdinaryEntity $entity, $record): array
    {
        $record['id'] = $entity->id;
        $record['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $record['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');

        return $record;
    }

    protected function ordinaryRecord2EntityBind($record, OrdinaryEntity $entity): OrdinaryEntity
    {
        $entity->id = $record['id'];
        $entity->dateCreated = new \DateTime($record['date_created']);
        $entity->dateModified = new \DateTime($record['date_modified']);

        return $entity;
    }

    abstract protected function entity2record(OrdinaryEntity $entity): array;

    abstract protected function record2entity(array $record): OrdinaryEntity;
}
