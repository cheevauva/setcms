<?php

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module;

class Action
{

    private ServerRequestInterface $request;
    private Module $module;
    private \ReflectionMethod $action;
    private string $method;
    private string $section;

    public function __construct(ServerRequestInterface $request)
    {
        $module = $request->getAttribute('module', '');
        $action = $request->getAttribute('action', 'index');
        $this->method = $request->getAttribute('method', '');
        $this->section = $request->getAttribute('section', 'Index');

        $this->request = $request;
        $moduleClassName = sprintf('SetCMS\Module\%s', $module);

        if (!class_exists($moduleClassName, true)) {
            throw ModuleException::notFoundModule($module);
        }

        $this->module = new $moduleClassName($module);

        assert($this->module instanceof Module);

        if (!method_exists($moduleClassName, 'getPrefix')) {
            throw ModuleException::notDefinedPrefix($this->module->getLabel());
        }

        $controllerClassName = $this->getControllerClassName();

        if (!method_exists($controllerClassName, $action)) {
            throw ModuleException::notFoundAction($this->module, $this->section, $action);
        }

        $this->action = (new \ReflectionClass($this->getControllerClassName()))->getMethod($action);

        $this->getController();
    }

    public function getModule(): Module
    {
        return $this->module;
    }

    public function getControllerClassName(): string
    {
        return sprintf('%s%s', $this->module->getPrefix(), ucfirst($this->section));
    }

    private function getController()
    {
        $comment = $this->action->getDocComment();

        if (stripos($comment, VarDoc::PREFIX_ACCESS . strtolower($this->section)) === false) {
            throw ModuleException::notAllowSectionAction($this->module, $this->action->getName(), $this->section);
        }

        if (stripos($comment, VarDoc::PREFIX_METHOD . strtolower($this->method)) === false) {
            throw ModuleException::notAllowActionForThatRequestMethod($this->module, $this->section, $this->action->getName(), $this->method);
        }

        return;
    }

    public function getComment(): string
    {
        return $this->action->getDocComment();
    }

    public function getArguments(): array
    {
        $arguments = [];

        foreach ($this->action->getParameters() as $parameter) {
            assert($parameter instanceof \ReflectionParameter);

            if ($parameter->getType()->getName() === ServerRequestInterface::class) {
                $arguments[$parameter->getPosition()] = $this->request;
            } else {
                $arguments[$parameter->getPosition()] = new ($parameter->getType()->getName());
            }
        }

        return $arguments;
    }

    public function getAction(): \ReflectionMethod
    {
        return $this->action;
    }

}
