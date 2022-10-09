<?php

namespace SetCMS\Module\OAuth\Scope;

use SetCMS\UUID;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthAuthorizeScope extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    private ?OAuthClientEntity $oauthClient = null;

    private const RESPONSE_TYPE_CODE = 'code';
    private const RESPONSE_TYPE_TOKEN = 'token';

    private array $responseTypes = [
        self::RESPONSE_TYPE_CODE,
        self::RESPONSE_TYPE_TOKEN
    ];
    public UUID $client_id;
    public string $response_type;
    public string $redirect_uri;

    public function satisfy(): \Iterator
    {
        parent::satisfy();

        if (!empty($this->response_type)) {
            if (!in_array($this->response_type, $this->responseTypes, true)) {
                yield ['response_type is wrong', 'username'];
            }
        }

        if (!empty($this->redirect_uri)) {
            if (parse_url($this->redirect_uri)['query'] ?? null) {
                yield ['redirect_uri is wrong, uri must not include a fragment component', 'username'];
            }
        }
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['model'] = [
            'client_id' => $this->client_id ?? null,
            'response_type' => $this->response_type ?? null,
            'redirect_uri' => $this->redirect_uri ?? null,
        ];

        return $array;
    }

}
