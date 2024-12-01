<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\Application\Contract\ContractArrayable;
use SetCMS\Application\Contract\ContractValidateInterface;
use SetCMS\Application\Contract\ContractScopeInterface;
use SetCMS\Application\Contract\ContractHydrateInterface;
use SetCMS\Core\Servant\CorePropertyFetchDataFromRequestServant;
use SetCMS\Core\Servant\CorePropertyHydrateServant;
use SetCMS\Core\Servant\CorePropertySatisfyServant;
use Psr\Http\Message\ServerRequestInterface;

abstract class Scope implements ContractHydrateInterface, ContractValidateInterface, ContractArrayable, ContractScopeInterface
{

    private array $messages = [];
    private array $data = [];
    private ?ServerRequestInterface $request;

    public function getMessages(): array
    {
        return $this->messages;
    }

    protected function catchToMessage($field, \Throwable $throwable): void
    {
        $this->messages[] = [
            'field' => $field,
            'message' => $throwable->getMessage(),
        ];
    }

    protected function withMessage(mixed $message): void
    {
        $this->messages[] = $message;
    }

    public function hasMessages(): bool
    {
        return !empty($this->messages);
    }

    public function validate(): \Iterator
    {
        yield from [];
    }

    public function from(object $object): void
    {
        if ($object instanceof CorePropertyHydrateServant) {
            foreach ($object->messages as $message) {
                $this->withMessage($message);
            }
        }

        if ($object instanceof CorePropertySatisfyServant) {
            foreach ($object->messages as $message) {
                $this->withMessage($message);
            }
        }

        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }

        if ($object instanceof CorePropertyFetchDataFromRequestServant) {
            $this->data = $object->data;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof CorePropertyHydrateServant) {
            $object->object = $this;
            $object->array = $this->data;
        }

        if ($object instanceof CorePropertySatisfyServant) {
            $object->object = $this;
        }

        if ($object instanceof CorePropertyFetchDataFromRequestServant) {
            $object->request = $this->request;
            $object->object = $this;
        }
    }

    public function toArray(): array
    {
        return [];
    }

}
