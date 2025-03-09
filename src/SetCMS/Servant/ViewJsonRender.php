<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Application\Contract\ContractApplicable;
use SetCMS\Controller;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\DTO\SetCMSOutputJsonDTO;

class ViewJsonRender extends \UUA\Servant
{

    public object $mixedValue;
    public ?string $json = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $json = new SetCMSOutputJsonDTO;
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
