<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthAppCode\DAO;

use SetCMS\Module\OAuth\OAuthAppCode\OAuthAppCodeEntity;
use SetCMS\Module\OAuth\OAuthApp\OAuthAppEntity;

class OAuthAppCodeEntityRetrieveByCodeAndAppDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use OAuthAppCodeEntityDbDAOTrait;

    public string $code;
    public OAuthAppEntity $oauthApp;
    public ?OAuthAppCodeEntity $OAuthAppCode = null;

    public function serve(): void
    {
        $this->criteria = [
            'code' => $this->code,
            'app_id' => (string) $this->oauthApp->id,
        ];

        parent::serve();

        $this->OAuthAppCode = $this->entity;
    }

}
