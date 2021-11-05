<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;

class OAuthModelDoAuthorize extends OAuthModelAuthorize
{
    /**
     * @setcms-required
     * @var string 
     */
    public string $username = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $password = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $captcha = '';


    protected function validate(): void
    {
        parent::validate();
    }


}
