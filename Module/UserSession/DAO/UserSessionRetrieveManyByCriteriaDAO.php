<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use SetCMS\DAO\EntityRetrieveManyByCriteriaDAO;
use Module\UserSession\UserSessionEntity;
use Module\UserSession\Exception\UserSessionNotFoundException;

class UserSessionRetrieveManyByCriteriaDAO extends EntityRetrieveManyByCriteriaDAO
{

    use UserSessionGenericDAO;

    /**
     * @var UserSessionEntity[]
     */
    public array $sessions; 
    public ?UserSessionEntity $session;

    public function serve(): void
    {
        parent::serve();

        $this->session = $this->first ? UserSessionEntity::as($this->first) : null;
        $this->sessions = UserSessionEntity::manyAs($this->entities);
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        throw new UserSessionNotFoundException();
    }
}
