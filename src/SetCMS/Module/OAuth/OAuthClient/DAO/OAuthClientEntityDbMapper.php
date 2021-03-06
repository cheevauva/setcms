<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientEntityDbMapper extends \SetCMS\Entity\EntityDbMapper
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
        $this->row['autorization_code_url'] = $this->entity()->autorizationCodeUrl;
        $this->row['userinfo_url'] = $this->entity()->userInfoUrl;
        $this->row['is_authorizable'] = (int) $this->entity()->isAuthorizable;
        $this->row['userinfo_parser_rule'] = $this->entity()->userInfoParserRule;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->name = $this->row['name'];
        $this->entity()->clientId = $this->row['client_id'];
        $this->entity()->clientSecret = $this->row['client_secret'];
        $this->entity()->redirectURI = $this->row['redirect_uri'] ?? '';
        $this->entity()->loginUrl = $this->row['login_url'] ?? '';
        $this->entity()->autorizationCodeUrl = $this->row['autorization_code_url'];
        $this->entity()->isAuthorizable = !empty($this->row['is_authorizable']);
        $this->entity()->userInfoUrl = $this->row['userinfo_url'] ?? '';
        $this->entity()->userInfoParserRule = $this->row['userinfo_parser_rule'] ?? '';
    }

}
