<?php

declare(strict_types=1);

namespace SetCMS\FrontController;

use SetCMS\Core\Form;
use SetCMS\Servant\BuildControllerWithReflectionMethodServant;

class TargetForm extends Form
{

    public string $module;
    public string $section;
    public string $action;

    public function fromArray(array $array): void
    {
        $this->module = $array['module'];
        $this->action = $array['action'];
        $this->section = $array['section'];
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
