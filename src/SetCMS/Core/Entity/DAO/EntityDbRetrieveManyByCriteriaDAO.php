<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\DAO;

use Doctrine\DBAL\Connection;
use SetCMS\ServantInterface;
use SetCMS\Core\Entity\EntityDbMapper;

abstract class EntityDbRetrieveManyByCriteriaDAO implements ServantInterface
{

    protected EntityDbMapper $mapper;
    protected Connection $db;
    protected array $criteria = [];
    protected string $table;
    protected ?int $limit = null;
    protected bool $forUpdate = false;
    public ?\Iterator $entities = null;

    public function serve(): void
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table);
        $qb->setMaxResults($this->limit);

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s = :%s', $field, $field));
            $qb->setParameter($field, $value);
        }
        
        $this->entities = $this->prepareEntities($qb->executeQuery()->iterateAssociative());
    }

    private function prepareEntities(\Iterator $rows): \Iterator
    {
        foreach ($rows as $row) {
            $this->mapper->entity = null;
            $this->mapper->row = new \ArrayObject($row);
            $this->mapper->serve();

            yield $this->mapper->entity;
        }
    }

}
