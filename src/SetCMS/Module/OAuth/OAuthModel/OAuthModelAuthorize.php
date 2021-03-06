<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class OAuthModelAuthorize extends OrdinaryModel
{

    private const RESPONSE_TYPE_CODE = 'code';
    private const RESPONSE_TYPE_TOKEN = 'token';

    private array $responseTypes = [
        self::RESPONSE_TYPE_CODE,
        self::RESPONSE_TYPE_TOKEN
    ];

    /**
     * @setcms-required
     * @var string 
     */
    public string $client_id = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $response_type = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $redirect_uri = '';


    protected function validate(): void
    {
        parent::validate();

        if (!empty($this->response_type)) {
            if (!in_array($this->response_type, $this->responseTypes, true)) {
                $this->addMessageAsValidation('response_type is wrong', 'username');
            }
        }

        if (!empty($this->redirect_uri)) {
            if (parse_url($this->redirect_uri)['query'] ?? null) {
                $this->addMessageAsValidation('redirect_uri is wrong, uri must not include a fragment component', 'username');
            }
        }
    }
    
    public function toArray(): array
    {
        $array = parent::toArray();
        
        return $array;
    }

}
