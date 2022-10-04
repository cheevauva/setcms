<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthCode\Mapper;

use SetCMS\Module\OAuth\OAuthCode\OAuthCodeEntity;

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
        $this->row['client_id'] = $this->entity()->clientId;
        $this->row['user_id'] = $this->entity()->userId;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->code = $this->row['code'];
        $this->entity()->userId = $this->row['user_id'];
        $this->entity()->clientId = $this->row['client_id'];
    }

}
