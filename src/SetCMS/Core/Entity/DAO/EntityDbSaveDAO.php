<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\DAO;

use SetCMS\Core\ServantInterface;
use SetCMS\Core\Entity\EntityDbMapper;
use SetCMS\Core\Entity;
use Doctrine\DBAL\Connection;

abstract class EntityDbSaveDAO implements ServantInterface
{

    protected EntityDbMapper $mapper;
    protected Connection $db;
    protected string $table;
    public Entity $entity;

    public function serve(): void
    {
        $this->mapper->entity = $this->entity;
        $this->mapper->row = null;
        $this->mapper->serve();

        if ($this->has($this->entity->id)) {
            $this->db->update($this->table, $this->mapper->row, ['id' => $this->entity->id]);
        } else {
            $this->db->insert($this->table, $this->mapper->row);
        }
    }

}
