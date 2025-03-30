<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

use SetCMS\Controller;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Module\Dynamic\Exception\DynamicClassNotFoundException;
use SetCMS\Module\Dynamic\Exception\DynamicExpectedAttributeNotDefinedException;
use SetCMS\Application\Router\RouterMatchDTO;

abstract class DynamicBaseController extends Controller
{

    protected Controller $controller;

    abstract protected function classNameControllerPattern(): string;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            $this->controller(),
        ];
    }

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        if (!isset($this->controller()->response)) {
            throw new \RuntimeException(sprintf('empty response for %s', get_class($this->controller())));
        }

        $this->response = $this->controller()->response;
    }

    protected function controller(): Controller
    {
        if (isset($this->controller)) {
            return $this->controller;
        }

        $routerMatch = RouterMatchDTO::as($this->request->getAttribute('routerMatch'));

        $module = $routerMatch->params['module'] ?? throw new DynamicExpectedAttributeNotDefinedException('module');
        $action = $routerMatch->params['action'] ?? throw new DynamicExpectedAttributeNotDefinedException('action');
        $id = $routerMatch->params['id'] ?? null;

        $className = strtr($this->classNameControllerPattern(), [
            '{module}' => ucfirst($module),
            '{action}' => ucfirst($action),
        ]);

        if (!class_exists($className, true)) {
            throw new DynamicClassNotFoundException($className);
        }

        if (is_a($className, __CLASS__, true)) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        $controller = $this->controller = Controller::as($className::new($this->container));
        $controller->request = $this->request->withAttribute('module', $module)->withAttribute('action', $action)->withAttribute('id', $id);

        $onBeforeServe = new ControllerOnBeforeServeEvent();
        $onBeforeServe->controller = $controller;
        $onBeforeServe->request = $this->request;
        $onBeforeServe->dispatch($this->eventDispatcher());

        return $controller;
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        parent::catch($object);

        if (isset($this->controller)) {
            $this->controller->catch($object);
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if (isset($this->controller)) {
            $this->controller->to($object);
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if (isset($this->controller)) {
            $this->controller->from($object);
        }
    }
}
