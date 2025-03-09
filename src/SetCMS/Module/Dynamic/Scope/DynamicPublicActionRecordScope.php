<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Scope;

use SetCMS\Application\Router\RouterMatchDTO;
use SetCMS\Controller;

class DynamicPublicActionRecordScope extends Controller
{

    protected string $module;
    protected string $action;
    protected string $id;
    protected Controller $scope;

    #[\Override]
    public function serve(): void
    {
        $scopeName = sprintf('%sPublic%sScope', ucfirst($this->module), ucfirst($this->action));

        if (!class_exists($scopeName, true)) {
            throw new \RuntimeException(sprintf('%s not found'), $scopeName);
        }

        $this->scope = Controller::as(new $scopeName);
        $this->scope->serve();
    }

    #[\Override]
    public function from(object $object): void
    {
        if ($object instanceof RouterMatchDTO) {
            $this->module = $object->params['module'];
            $this->action = $object->params['action'];
            $this->id = $object->params['id'];
        }
    }

    #[\Override]
    public function toArray()
    {
        return $this->scope->toArray();
    }
}
