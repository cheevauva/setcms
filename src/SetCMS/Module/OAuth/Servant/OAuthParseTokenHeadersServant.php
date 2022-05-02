<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

class OAuthParseTokenHeadersServant implements \SetCMS\ServantInterface
{

    public array $tokens;
    public array $parsedTokens;

    public function serve(): void
    {
        $this->parsedTokens = [];

        foreach ($this->tokens as $token) {
            $parsed = array_filter(explode(' ', $token, 2));

            if (empty($parsed)) {
                continue;
            }

            if (count($parsed) === 1) {
                $parsedTokenType = 'Bearer';
                $parsedToken = reset($parsed);
            } else {
                list($parsedTokenType, $parsedToken) = $parsed;
            }

            switch ($parsedTokenType) {
                case 'Bearer':
                    $this->parsedTokens[] = $parsedToken;
                    break;
            }
        }
    }

}
