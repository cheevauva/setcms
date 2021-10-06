<?php

namespace SetCMS\Module\Ordinary;

use SetCMS\Module\Ordinary\OrdinaryEntity;
use Doctrine\DBAL\Connection;

abstract class OrdinaryDAO
{

    abstract protected function getTableName(): string;

    abstract protected function getException(): \Exception;

    abstract function getDatabase(): Connection;

    public function list(int $offset = 0, $limit = 10, string $sort = 'id', string $order = ''): array
    {
        $qb = $this->getDatabase()->createQueryBuilder();
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

    public function getById(int $id): OrdinaryEntity
    {
        $qb = $this->getDatabase()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->getTableName(), 't');
        $qb->andWhere('t.id = :id');
        $qb->setParameter('id', $id);
        $qb->setMaxResults(1);

        $row = $qb->fetchAssociative();

        if (empty($row)) {
            throw $this->getException()::notFound();
        }

        return $this->record2entity($row);
    }

    public function save(OrdinaryEntity $entity): void
    {
        $db = $this->getDatabase();

        if (empty($entity->id)) {
            $db->insert($this->getTableName(), $this->entity2record($entity));

            $entity->id = $db->lastInsertId();
        } else {
            $db->update($this->getTableName(), $this->entity2record($entity), ['id' => $entity->id]);
        }
    }

    protected function ordinaryEntity2RecordBind(OrdinaryEntity $entity, $record): array
    {
        $record['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $record['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');

        return $record;
    }

    protected function ordinaryRecord2EntityBind($record, OrdinaryEntity $entity): OrdinaryEntity
    {
        $entity->id = (int) $record['id'];
        $entity->dateCreated = new \DateTime($record['date_created']);
        $entity->dateModified = new \DateTime($record['date_modified']);
        
        return $entity;
    }

    abstract protected function entity2record(OrdinaryEntity $entity): array;

    abstract protected function record2entity(array $record): OrdinaryEntity;
}
