<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\UUID;

class UserSessionMapper extends EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): UserSessionEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['device'] = mb_substr($this->entity()->device, 0, 50);
        $this->row['user_id'] = strval($this->entity()->userId);
        $this->row['date_expiries'] = $this->entity()->dateExpiries->format('Y-m-d H:i:s');
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->device = $this->row['device'];
        $this->entity()->userId = new UUID($this->row['user_id']);
        $this->entity()->dateExpiries = new \DateTime($this->row['date_expiries']);
    }

}
