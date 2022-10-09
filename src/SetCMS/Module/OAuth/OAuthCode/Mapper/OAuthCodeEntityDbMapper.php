<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthCode\Mapper;

use SetCMS\Module\OAuth\OAuthCode\OAuthCodeEntity;
use SetCMS\UUID;

class OAuthCodeEntityDbMapper extends \SetCMS\Entity\Mapper\EntityDbMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): OAuthCodeEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['code'] = $this->entity()->code;
        $this->row['client_id'] = (string) $this->entity()->clientId;
        $this->row['user_id'] = (string) $this->entity()->userId;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->code = $this->row['code'];
        $this->entity()->userId = new UUID($this->row['user_id']);
        $this->entity()->clientId = new UUID($this->row['client_id']);
    }

}
