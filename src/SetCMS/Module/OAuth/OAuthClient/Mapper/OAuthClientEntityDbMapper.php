<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Mapper;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientEntityDbMapper extends \SetCMS\Entity\Mapper\EntityDbMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): OAuthClientEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['name'] = $this->entity()->name;
        $this->row['client_id'] = $this->entity()->clientId;
        $this->row['client_secret'] = $this->entity()->clientSecret;
        $this->row['redirect_uri'] = $this->entity()->redirectURI;
        $this->row['login_url'] = $this->entity()->loginUrl;
        $this->row['is_authorizable'] = (int) $this->entity()->isAuthorizable;
        //$this->row['autorization_code_url'] = $this->entity()->autorizationCodeUrl;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->name = $this->row['name'];
        $this->entity()->clientId = $this->row['client_id'];
        $this->entity()->clientSecret = $this->row['client_secret'];
        $this->entity()->redirectURI = $this->row['redirect_uri'] ?? '';
        $this->entity()->loginUrl = $this->row['login_url'] ?? '';
        $this->entity()->isAuthorizable = !empty($this->row['is_authorizable']);
        //$this->entity()->autorizationCodeUrl = $this->row['autorization_code_url'];
    }

}
