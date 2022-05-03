<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\ServantInterface;
use SetCMS\Entity\EntityDbMapper;
use SetCMS\Entity;
use Doctrine\DBAL\Connection;

abstract class EntityDbSaveDAO implements ServantInterface
{

    protected EntityDbMapper $mapper;
    protected Connection $db;
    protected string $table;
    public Entity $entity;

    private function has(string $id): bool
    {

        $qb = $this->db->createQueryBuilder();
        $qb->select('id');
        $qb->from($this->table);
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $id);
        $qb->setMaxResults(1);
        
        return !!$qb->fetchOne();
    }
    
    public function serve(): void
    {
        $this->mapper->entity = $this->entity;
        $this->mapper->row = new \ArrayObject;
        $this->mapper->serve();

        if ($this->has($this->entity->id)) {
            $this->db->update($this->table, $this->mapper->row->getArrayCopy(), ['id' => $this->entity->id]);
        } else {
            $this->db->insert($this->table, $this->mapper->row->getArrayCopy());
        }
    }

}
