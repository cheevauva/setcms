<?php

namespace SetCMS;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\VarDoc;
use SetCMS\Module\Modules\ModuleDAO;
use SetCMS\Module\Module;
use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\Modules\Contract\ModuleIndexInterface;
use SetCMS\Module\Modules\ModuleException;
use Psr\Container\ContainerInterface;

class Action
{

    private ServerRequestInterface $request;
    private \ReflectionMethod $action;
    private string $requestMethod;
    private string $section;
    private ModuleDAO $moduleDAO;
    private Module $module;
    private ContainerInterface $container;

    public function __construct(ModuleDAO $moduleDAO, ContainerInterface $container)
    {
        $this->moduleDAO = $moduleDAO;
        $this->container = $container;
    }

    public function withRequest(ServerRequestInterface $request): self
    {
        $module = $this->moduleDAO->find($request->getAttribute('module'));

        $action = $request->getAttribute('action', $module->getDefaultAction());
        $section = $request->getAttribute('section', $module->getDefaultSection());
        $controller = $module->getSectionClassName($section);
        $requestMethod = $request->getAttribute('method', $request->getMethod());

        if (!method_exists($controller, $action)) {
            throw ModuleException::notFoundAction($module, $section, $action);
        }

        $this->request = $request;
        $this->requestMethod = $requestMethod;
        $this->module = $module;
        $this->section = $section;
        $this->action = (new \ReflectionClass($controller))->getMethod($action);

        return $this;
    }

    private function getControllerClassName(): string
    {
        return $this->module->getSectionClassName($this->section);
    }

    public function hasResponseHeaders(): bool
    {
        return strpos($this->getComment(), VarDoc::RESPONSE_WITH_HEADERS) !== false;
    }

    public function getCallbackHeaderName(): string
    {
        return implode('.', [
            $this->module->getName(),
            $this->section,
            $this->action->getName()
        ]);
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

    private function getSection(): string
    {
        return $this->section;
    }

    private function isAllowRequestMethod(): bool
    {
        if ($this->section === 'Resource') {
            return true;
        }

        return stripos($this->action->getDocComment(), VarDoc::PREFIX_METHOD . strtolower($this->requestMethod)) !== false;
    }

    private function getComment(): string
    {
        return $this->action->getDocComment();
    }

    private function getArguments(): array
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

    private function getAction(): \ReflectionMethod
    {
        return $this->action;
    }

    public function getResourceRule(): array
    {
        switch ($this->section) {
            case 'Resource':
                $resource = $this->request->getAttribute('resource');
                $rule = $this->request->getAttribute('action');
                break;
            case 'Index':
            case 'Admin':
                $resource = $this->module->getName();
                $rule = $this->action->getDeclaringClass()->getShortName() . '::' . $this->action->getName();
                break;
        }

        return [$resource, $rule];
    }

    public function __invoke()
    {
        if (!$this->action->isPublic()) {
            throw ModuleException::notAllow();
        }
        
        if (!$this->isAllowRequestMethod()) {
            throw ModuleException::notAllowActionForThatRequestMethod($this->module, $this->section, $this->action->getName(), $this->request->getMethod());
        }

        return $this->action->invokeArgs($this->container->get($this->getControllerClassName()), $this->getArguments());
    }

    public function getTemplate($theme)
    {
        return sprintf('themes/%s/modules/%s/%s/%s.twig', $theme, $this->module->getName(), $this->section, $this->action->getName());
    }

}
