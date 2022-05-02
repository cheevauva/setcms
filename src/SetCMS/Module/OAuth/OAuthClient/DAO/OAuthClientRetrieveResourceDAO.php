<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use GuzzleHttp\Client;

class OAuthClientRetrieveResourceDAO implements \SetCMS\ServantInterface
{

    public string $url;
    public array $oauthData;
    public array $data;

    public function serve(): void
    {
        $preparedUrl = strtr($this->url, [
            '{accessToken}' => $this->oauthData['access_token'],
        ]);

        $response = (new Client())->request('GET', $preparedUrl, [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                // 'Content-type' => 'application/json',
                'Authorization' => implode(' ', array_filter([$this->oauthData['token_type'] ?? null, $this->oauthData['access_token']]))
            ],
        ]);

        $this->data = json_decode($response->getBody()->getContents(), true);

        if (is_null($this->data) && json_last_error()) {
            $response->getBody()->rewind();

            throw OAuthClientException::autorizationCodeFail(json_last_error_msg() . ': ' . $response->getBody()->getContents());
        }

        if (!empty($this->data['error'])) {
            throw OAuthClientException::autorizationCodeFail($this->data['error_description'] ?? json_encode($this->data, JSON_UNESCAPED_UNICODE));
        }
    }

}
