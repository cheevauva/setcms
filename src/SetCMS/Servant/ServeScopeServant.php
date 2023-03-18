<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Core\Servant\CorePropertyHydrateSevant;
use SetCMS\Core\Servant\CorePropertySatisfyServant;
use SetCMS\Contract\Servant;
use SetCMS\Scope;

class ServeScopeServant implements Servant
{

    use \SetCMS\QuickTrait;

    public Servant $servant;
    public Scope $scope;
    public array $array = [];

    public function serve(): void
    {
        $messages = iterator_to_array($this->messages());

        if (empty($messages)) {
            $this->scope->to($this->servant);
            $this->servant->serve();
            $this->scope->from($this->servant);
        }

        $this->scope->withMessages($messages);
    }

    protected function messages(): \Iterator
    {
        $hydrator = CorePropertyHydrateSevant::make($this->factory());
        $hydrator->array = $this->array;
        $hydrator->object = $this->scope;
        $hydrator->serve();

        $satisfyer = CorePropertySatisfyServant::make($this->factory());
        $satisfyer->object = $this->scope;
        $satisfyer->serve();
       
        foreach ($hydrator->messages as $message) {
            yield $message;
        }
        
        foreach ($satisfyer->messages as $message) {
            yield $message;
        }
    }

}
