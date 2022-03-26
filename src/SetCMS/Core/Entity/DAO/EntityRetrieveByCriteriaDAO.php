<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\DAO;

use Doctrine\DBAL\Connection;
use SetCMS\Core\ServantInterface;
use SetCMS\Core\Entity\EntityDbMapper;
use SetCMS\Core\Entity;
use SetCMS\Core\Entity\Exception\EntityNotFoundException;

abstract class EntityRetrieveByCriteriaDAO implements ServantInterface
{

    protected EntityDbMapper $mapper;
    protected Connection $db;
    protected array $criteria = [];
    protected string $table;
    public ?Entity $entity = null;

    public function serve(): void
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table);

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s = :%s', $field, $field));
            $qb->setParameter($field, $value);
        }

        $qb->setMaxResults(1);

        $row = $qb->fetchAssociative();

        if (!$row) {
            throw EntityNotFoundException::make();
        }

        $this->mapper->row = new \ArrayObject($row);
        $this->mapper->serve();

        $this->entity = $this->mapper->entity;
    }

}
