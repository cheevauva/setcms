<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;

class OAuthTokenEntityDbMapper extends \SetCMS\Entity\EntityDbMapper
{

    protected function entity(): OAuthTokenEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['token'] = $this->entity()->token;
        $this->row['refresh_token'] = $this->entity()->refreshToken;
        $this->row['client_id'] = $this->entity()->clientId;
        $this->row['user_id'] = $this->entity()->userId;
        $this->row['date_expired'] = $this->entity()->dateExpiried->format('Y-m-d H:i:s');
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->token = $this->row['token'];
        $this->entity()->refreshToken = $this->row['refresh_token'];
        $this->entity()->clientId = $this->row['client_id'];
        $this->entity()->userId = $this->row['user_id'];
        $this->entity()->dateExpiried = new \DateTime($this->row['date_expired']);
    }


}
