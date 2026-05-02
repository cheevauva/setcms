<?php

declare(strict_types=1);

namespace SetCMS\View;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View\View;

class ViewJson extends View
{

    use \SetCMS\Traits\TraitsResponse;

    public public(set) ServerRequestInterface $request;

    #[\Override]
    public function serve(): void
    {
        $json = json_encode([
            'result' => $this->messages->count() === 0,
            'data' => $this->data(),
            'messages' => null,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        
        if (!is_string($json)) {
            if (json_last_error_msg()) {
                throw new \Exception(json_last_error_msg());
            } else {
                throw new \Exception('json must be string');
            }
        }

        $this->response = $this->newResponse()->withStatus(200)->withHeader('Content-Type', 'application/json');
        $this->response->getBody()->write($json);
    }

    /**
     * @return array<string|mixed>
     */
    protected function data(): array
    {
        $vars = get_object_vars($this);

        unset($vars['ctx']);
        unset($vars['container']);
        unset($vars['messages']);
        unset($vars['response']);

        return $vars;
    }
}
