<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Controller;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\DTO\SetCMSOutputDTO;

class ViewJsonRender extends \UUA\Servant
{

    public public(set) object $mixedValue;
    public protected(set) ?string $json = null;
    public public(set) ServerRequestInterface $request;

    public function serve(): void
    {
        $json = new SetCMSOutputDTO;
        $object = $this->mixedValue;

        if ($object instanceof Controller) {
            $object->to($json);
        }

        $this->json = json_encode([
            'result' => $json->isSuccess,
            'data' => $json->data(),
            'messages' => $json->messages(),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
