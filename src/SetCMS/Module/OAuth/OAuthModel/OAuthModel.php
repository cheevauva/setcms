<?php

namespace SetCMS\Module\OAuth\OAuthModel;

class OAuthModel extends \SetCMS\Model
{

    public function toArray(): array
    {
        $response = [];

        if ($this->messages) {
            $message = reset($this->messages);
            $response['error'] = $message['field'];
            $response['error_description'] = $message['message'];
        }

        return $response;
    }

}
