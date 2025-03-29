<?php

declare(strict_types=1);

namespace SetCMS\View;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View;
use Laminas\Diactoros\Response;

class ViewJson extends View
{

    public public(set) ServerRequestInterface $request;

    public function serve(): void
    {
        $json = json_encode([
            'result' => !$this->messages->count(),
            'data' => $this->data(),
            'messages' => $this->prepareMessages(),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $response = (new Response())->withStatus(200)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write($json);

        $this->response = $response;
    }

    protected function prepareMessages(): array
    {
        $messages = [];

        $this->messages->rewind();

        while ($this->messages->valid()) {
            $object = $this->messages->current();
            $message = 'Неизвестное сообщение';

            if ($object instanceof \Throwable) {
                $message = $object->getMessage();
            }

            $messages[] = [
                'field' => $this->messages->getInfo(),
                'message' => $message
            ];
            
            $this->messages->next();
        }

        return $messages;
    }

    protected function data(): array
    {
        $vars = get_object_vars($this);

        unset($vars['container']);
        unset($vars['messages']);
        unset($vars['response']);

        return $vars;
    }
}
