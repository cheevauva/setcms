<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\Mapper;

use SetCMS\Entity\Mapper\EntityMapper;
use SetCMS\Module\OAuth\OAuthApp\OAuthAppEntity;

class OAuthAppEntityDbMapper extends EntityMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): OAuthAppEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['name'] = $this->entity()->name;
        $this->row['client_id'] = $this->entity()->clientId;
        $this->row['client_secret'] = $this->entity()->clientSecret;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->name = $this->row['name'];
        $this->entity()->clientId = $this->row['client_id'];
        $this->entity()->clientSecret = $this->row['client_secret'];
    }

}
