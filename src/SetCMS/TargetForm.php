<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\Core\Form;
use SetCMS\Servant\BuildControllerWithReflectionMethodServant;

class TargetForm extends Form
{

    public string $action;
    public string $module;
    public string $section;
    public string $method;

    public function fromArray(array $array): void
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }
    }
    
    public function apply(object $object): void
    {
        parent::apply($object);
        
        if ($object instanceof BuildControllerWithReflectionMethodServant) {
            $object->module = $this->module;
            $object->action = $this->action;
            $object->section = $this->section;
        }
    }

}
