<?php

namespace SetCMS\Module\OAuth\OAuthModel;

class OAuthModelAuthorize extends \SetCMS\Model
{

    public string $client_id = '';
    public string $response_type = '';
    public string $redirect_uri = '';

    protected function validate(): void
    {
        if (empty($this->client_id)) {
            $this->addMessageAsValidation('client_id is required', 'invalid_request');
        }

        if (empty($this->response_type)) {
            $this->addMessageAsValidation('response_type is required', 'invalid_request');
        } else {
            if (!in_array($this->response_type, ['code', 'token'], true)) {
                $this->addMessageAsValidation('response_type is wrong', 'invalid_request');
            }
        }

        if (!empty($this->redirect_uri)) {
            if (parse_url($this->redirect_uri)['query'] ?? null) {
                $this->addMessageAsValidation('redirect_uri is wrong, uri must not include a fragment component', 'invalid_request');
            }
        }
    }

    public function toArray(): array
    {
        $response = [];

        if ($this->messages) {
            $message = reset($this->messages);
            $response['error_description'] = $message['message'];
            $response['error'] = $message['field'];
        }

        return $response;
    }

}
