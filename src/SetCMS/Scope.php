<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\Contract\Arrayable;
use SetCMS\Contract\Satisfiable;
use SetCMS\Contract\Hydratable;
use SetCMS\Core\Servant\CorePropertyHydrateSevant;
use SetCMS\Core\Servant\CorePropertySatisfyServant;
use Psr\Http\Message\ServerRequestInterface;

abstract class Scope implements Hydratable, Satisfiable, Arrayable
{

    private array $messages = [];
    private array $data = [];
    //
    protected ServerRequestInterface $request;

    public function getMessages(): array
    {
        return $this->messages;
    }

    protected function withMessage(mixed $message): void
    {
        $this->messages[] = $message;
    }

    public function hasMessages(): bool
    {
        return !empty($this->messages);
    }

    public function satisfy(): \Iterator
    {
        yield from [];
    }

    public function from(object $object): void
    {
        if ($object instanceof CorePropertyHydrateSevant) {
            foreach ($object->messages as $message) {
                $this->withMessage($message);
            }
        }

        if ($object instanceof CorePropertySatisfyServant) {
            foreach ($object->messages as $message) {
                $this->withMessage($message);
            }
        }

        if ($object instanceof CoreServerRequestAttributeServat) {
            $this->data = $object->data;
        }

        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }

        if ($object instanceof \Throwable) {
            $this->withMessage($object->getMessage());
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof CoreServerRequestAttributeServat) {
            $object->object = $this;
            $object->request = $this->request;
        }

        if ($object instanceof CorePropertyHydrateSevant) {
            $object->object = $this;
            $object->array = $this->serverRequest->getParsedBody();
            $object->serve();
        }

        if ($object instanceof CorePropertySatisfyServant) {
            $object->object = $this;
        }
    }

    public function toArray(): array
    {
        return [];
    }

}
