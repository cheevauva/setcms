<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\OAuth\OAuthToken;

class OAuthModelCallback extends OrdinaryModel
{

    /**
     * @setcms-required
     * @var string 
     */
    public string $client_id = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $code = '';

    /**
     * @var string|null
     */
    public ?string $cms_token = null;

    public function entity(?\SetCMS\Module\Ordinary\OrdinaryEntity $entity = null): ?OAuthToken
    {
        return parent::entity($entity);
    }
    
}
