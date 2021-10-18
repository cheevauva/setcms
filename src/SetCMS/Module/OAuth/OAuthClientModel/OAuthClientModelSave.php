<?php

namespace SetCMS\Module\OAuth\OAuthClientModel;

use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class OAuthClientModelSave extends OrdinaryModel
{

    public ?int $id = null;

    /**
     * @setcms-required
     * @var string 
     */
    public string $name = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $clientId = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $clientSecret = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $redirectURI = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $loginUrl = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $autorizationCodeUrl = '';
    public bool $isAuthorizable = false;
    public string $userInfoParserRule = '';
    public string $userInfoUrl = '';

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): OAuthClient
    {
        assert($entity instanceof OAuthClient);

        foreach (get_object_vars($this) as $key => $value) {
            $entity->{$key} = $value;
        }

        return $entity;
    }

}
