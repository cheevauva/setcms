<?php

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module;

class Action
{

    private ServerRequestInterface $request;
    private Module $module;
    private \ReflectionMethod $action;

    public function __construct(string $module, string $action, ServerRequestInterface $request)
    {
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

//                if (!method_exists($className, $match['action'])) {
//                    throw ModuleException::notFoundAction($module->getModule(), $match['section'], $match['action']);
//                }

        $this->action = (new \ReflectionClass($this->getControllerClassName()))->getMethod($action);
    }

    public function getModule(): Module
    {
        return $this->module;
    }

    public function getControllerClassName(): string
    {
        return sprintf('%s%s', $this->module->getPrefix(), 'Index');
    }

    protected function getController()
    {
        $comment = $this->action->getDocComment();

        if (stripos($comment, VarDoc::PREFIX_ACCESS . 'index') === false) {
            throw ModuleException::notAllowSectionAction($this->module->getModule(), $match['action'], $match['section']);
        }

        if (stripos($comment, VarDoc::PREFIX_METHOD . 'get') === false) {
            throw ModuleException::notAllowActionForThatRequestMethod($this->module->getModule(), $match['section'], $match['action'], $requestMethod);
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
