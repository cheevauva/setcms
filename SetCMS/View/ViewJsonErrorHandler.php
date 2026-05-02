<?php

declare(strict_types=1);

namespace SetCMS\View;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View\View;

class ViewJsonErrorHandler extends View
{

    use \SetCMS\Traits\TraitsResponse;

    public public(set) ServerRequestInterface $request;

    #[\Override]
    public function serve(): void
    {
        if (!$this->messages->count()) {
            return;
        }

        $json = json_encode([
            'result' => false,
            'data' => null,
            'messages' => $this->prepareMessages(),
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
     * @return array<int|array<string|mixed>>
     */
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
}
