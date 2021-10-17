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
    public string $client_id = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $client_secret = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $redirect_uri = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $login_url = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $autorization_code_url = '';

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): OAuthClient
    {
        assert($entity instanceof OAuthClient);

        $entity->id = $this->id;
        $entity->name = $this->name;
        $entity->clientId = $this->client_id;
        $entity->clientSecret = $this->client_secret;
        $entity->loginUrl = $this->login_url;
        $entity->autorizationCodeUrl = $this->autorization_code_url;
        $entity->redirectURI = $this->redirect_uri;

        return $entity;
    }

}
