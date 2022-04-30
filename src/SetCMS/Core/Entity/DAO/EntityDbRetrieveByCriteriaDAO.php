<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\DAO;

use Doctrine\DBAL\Connection;
use SetCMS\Core\Entity\EntityDbMapper;
use SetCMS\Core\Entity;
use SetCMS\Core\Entity\EntityException;

abstract class EntityDbRetrieveByCriteriaDAO extends EntityDbRetrieveManyByCriteriaDAO
{

    protected EntityDbMapper $mapper;
    protected Connection $db;
    protected array $criteria = [];
    protected string $table;
    protected ?int $limit = 1;
    public ?Entity $entity = null;

    public function serve(): void
    {
        parent::serve();

        foreach ($this->entities as $entity) {
            $this->entity = $entity;
        }

        if (!$this->entity) {
            throw EntityException::notFound();
        }
    }

}
