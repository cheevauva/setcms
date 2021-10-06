<?php

namespace SetCMS\Module\Ordinary\OrdinaryModel;

class OrdinaryModelError extends \SetCMS\Model
{

    public string $message;
    public string $trace;

    public function toArray(): array
    {
        $array = get_object_vars($this);
        $array['model'] = $this;
        
        return $array;
    }

}
