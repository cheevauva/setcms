<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\DAO;

use SetCMS\Module\OAuth\OAuthUser\OAuthUserEntity;

class OAuthUserEntityDbRetrieveByExternalIdAndClientIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use OAuthUserEntityDbDAOTrait;

    public string $exteranalId;
    public string $clientId;
    public ?OAuthUserEntity $oauthUser = null;

    public function serve(): void
    {
        parent::serve();

        $this->oauthUser = $this->entity;
    }

}
