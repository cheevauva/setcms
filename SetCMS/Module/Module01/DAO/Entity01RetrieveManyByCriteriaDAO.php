<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01RetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use Entity01CommonDAO;

    /**
     * @var array<Entity01Entity>
     */
    public array $Entity01LCs;
    public ?Entity01Entity $Entity01LC;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->Entity01LCs = Entity01Entity::manyAs($this->entities);
        $this->Entity01LC = $this->first ? Entity01Entity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new Entity01NotFoundException();
    }
}
