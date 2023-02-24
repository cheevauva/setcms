<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Mapper;

use SetCMS\Entity\Mapper\EntityMapper;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\UUID;

class SessionMapper extends EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): SessionEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['device'] = $this->entity()->device;
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
