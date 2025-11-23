<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use UUA\Servant;
use SetCMS\Entity\Entity;
use SetCMS\DAO\EntityHasByIdDAO;
use SetCMS\DAO\EntityCreateDAO;
use SetCMS\DAO\EntityUpdateDAO;

/**
 * @template E of Entity
 */
abstract class EntitySaveServant extends Servant
{

    /**
     * @var E
     */
    public Entity $entity;

    /**
     * @var class-string
     */
    public string $clsHas;

    /**
     * @var class-string
     */
    public string $clsUpdate;

    /**
     * @var class-string
     */
    public string $clsCreate;

    #[\Override]
    public function serve(): void
    {
        $has = EntityHasByIdDAO::as(($this->clsHas)::new($this->container));
        $has->id = $this->entity->id;
        $has->serve();

        if ($has->isExists) {
            $update = EntityUpdateDAO::as(($this->clsUpdate)::new($this->container));
            $update->entity = $this->entity;
            $update->serve();
        } else {
            $create = EntityCreateDAO::as(($this->clsCreate)::new($this->container));
            $create->entity = $this->entity;
            $create->serve();
        }
    }
}
