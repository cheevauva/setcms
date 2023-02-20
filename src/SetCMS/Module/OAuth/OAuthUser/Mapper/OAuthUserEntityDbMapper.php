<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\Mapper;

use SetCMS\Module\OAuth\OAuthUser\OAuthUserEntity;

class OAuthUserEntityDbMapper extends \SetCMS\Entity\Mapper\EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): OAuthUserEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['client_id'] = $this->entity()->clientId;
        $this->row['external_id'] = $this->entity()->externalId;
        $this->row['user_id'] = $this->entity()->userId;
        $this->row['refresh_token'] = $this->entity()->refreshToken;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->clientId = $this->row['client_id'];
        $this->entity()->externalId = $this->row['external_id'];
        $this->entity()->userId = $this->row['user_id'];
        $this->entity()->refreshToken = $this->row['refresh_token'];
    }

}
