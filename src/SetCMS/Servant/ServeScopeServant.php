<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Servant\ArrayPropertyHydratorSevant;
use SetCMS\ServantInterface;
use SetCMS\Scope;

class ServeScopeServant implements ServantInterface
{

    public ServantInterface $servent;
    public Scope $scope;
    public array $array = [];

    public function serve(): void
    {
        try {
            $messages = iterator_to_array($this->messages());

            if (empty($messages)) {
                $this->scope->to($this->servent);
                $this->servent->serve();
                $this->scope->from($this->servent);
            }
        } catch (\Exception $ex) {
            $messages[] = [$ex->getMessage(), null];
        }

        $this->scope->messages = $messages;
    }

    protected function messages(): \Iterator
    {
        $hydrator = new ArrayPropertyHydratorSevant;
        $hydrator->array = $this->array;
        $hydrator->object = $this->scope;
        $hydrator->serve();

        if ($hydrator->messages) {
            yield from $hydrator->messages;
            return;
        }

        yield from $this->scope->satisfy();
    }

}
