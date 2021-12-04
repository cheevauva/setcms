<?php

namespace SetCMS\Responder;

class Json extends Responder
{
    public ?string $wrapper = null;

    protected function getContent(): string
    {
        switch ($this->wrapper) {
            case 'json-none':
                $data = $this->model->toArray();
                break;
            default:
                $data = [
                    'success' => empty($this->model->getMessages()),
                    'result' => $this->model->toArray(),
                    'messages' => $this->model->getMessages(),
                ];
                break;
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    protected function getContentType(): string
    {
        return 'application/json';
    }

}
