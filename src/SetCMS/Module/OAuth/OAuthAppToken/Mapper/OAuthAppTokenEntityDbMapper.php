<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthAppToken\Mapper;

use SetCMS\Module\OAuth\OAuthAppToken\OAuthAppTokenEntity;
use SetCMS\UUID;

class OAuthAppTokenEntityDbMapper extends \SetCMS\Entity\Mapper\EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): OAuthAppTokenEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['token'] = $this->entity()->token;
        $this->row['refresh_token'] = $this->entity()->refreshToken;
        $this->row['client_id'] = (string) $this->entity()->clientId;
        $this->row['user_id'] = (string) $this->entity()->userId;
        $this->row['date_expired'] = $this->entity()->dateExpiried->format('Y-m-d H:i:s');
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->token = $this->row['token'];
        $this->entity()->refreshToken = $this->row['refresh_token'];
        $this->entity()->clientId = new UUID($this->row['client_id']);
        $this->entity()->userId = new UUID($this->row['user_id']);
        $this->entity()->dateExpiried = new \DateTime($this->row['date_expired']);
    }

}
