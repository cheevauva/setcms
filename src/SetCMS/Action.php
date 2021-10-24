<?php

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module;
use SetCMS\VarDoc;

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
    }

    public function hasResponseHeaders(): bool
    {
        return strpos($this->getComment(), VarDoc::RESPONSE_WITH_HEADERS) !== false;
    }

    public function isCSRFProtectEnabled(): bool
    {
        return strpos($this->getComment(), VarDoc::CSRF_PROTECT_DISABLED) === false;
    }

    public function getWrapper(): ?string
    {
        $comment = $this->getComment();
        $wrappers = [
            VarDoc::WRAPPER_JSON_NONE => 'json-none',
        ];
        foreach ($wrappers as $contentType => $type) {
            if (strpos($comment, $contentType) !== false) {
                return $type;
            }
        }

        return null;
    }

    public function getContentType(): string
    {
        if ($this->section === 'Resource') {
            return 'json';
        }

        $comment = $this->getComment();
        $contentTypes = [
            VarDoc::RESPONSE_HTML => 'html',
            VarDoc::RESPONSE_JSON => 'json',
        ];

        foreach ($contentTypes as $contentType => $type) {
            if (strpos($comment, $contentType) !== false) {
                return $type;
            }
        }

        throw ModuleException::serverError('Не указан тип возвращаемого контента');
    }

    public function getSection(): string
    {
        return $this->section;
    }

    public function getModule(): Module
    {
        return $this->module;
    }

    public function getControllerClassName(): string
    {
        return sprintf('%s%s', $this->module->getPrefix(), ucfirst($this->section));
    }

    public function isAllowRequestMethod(): bool
    {
        if ($this->section === 'Resource') {
            return true;
        }

        return stripos($this->action->getDocComment(), VarDoc::PREFIX_METHOD . strtolower($this->method)) !== false;
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
                $className = $parameter->getType()->getName();
                $arguments[$parameter->getPosition()] = new $className;
            }
        }

        return $arguments;
    }

    public function getAction(): \ReflectionMethod
    {
        return $this->action;
    }

}
