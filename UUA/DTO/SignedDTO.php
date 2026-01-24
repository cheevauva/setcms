<?php

declare(strict_types=1);

namespace UUA\DTO;

use SetCMS\Contract\ContractObjectInteraction;

class SignedDTO extends \UUA\DTO
{

    public function __construct(public string $name, public ?object $object = null)
    {
        
    }

    public function to(ContractObjectInteraction $object): void
    {
        $object->from($this);
    }

    public function from(ContractObjectInteraction $object): ?object
    {
        $object->to($this);

        return $this->object;
    }
}
