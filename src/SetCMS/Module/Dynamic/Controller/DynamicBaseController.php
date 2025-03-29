<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Controller;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Module\Dynamic\Exception\DynamicClassNotFoundException;
use SetCMS\Module\Dynamic\Exception\DynamicRequestMethodNotDefinedException;
use SetCMS\Module\Dynamic\Exception\DynamicRequestMethodNotAllowedException;
use SetCMS\Module\Dynamic\Exception\DynamicExpectedAttributeNotDefinedException;
use SetCMS\Application\Router\RouterMatchDTO;
use SetCMS\View;
use SetCMS\Responder;
use Psr\Http\Message\ResponseInterface;
use UUA\Unit;

abstract class DynamicBaseController extends Controller
{

    protected string $module;
    protected string $action;
    protected Controller $controller;
    protected null|View|Responder $responderOrView;
    protected protected(set) ResponseInterface $response;

    abstract protected function classNameControllerPattern(): string;

    abstract protected function classNameResponderViewPatterns(): array;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            $this->controller,
        ];
    }


    #[\Override]
    protected function viewUnits(): array
    {
        return array_filter([
            $this->responderOrView,
        ]);
    }

    #[\Override]
    public function serve(): void
    {
        $routerMatch = RouterMatchDTO::as($this->request->getAttribute('routerMatch'));

        $this->module = $routerMatch->params['module'] ?? throw new DynamicExpectedAttributeNotDefinedException('module');
        $this->action = $routerMatch->params['action'] ?? throw new DynamicExpectedAttributeNotDefinedException('action');

        $this->responderOrView = $this->responderOrView();
        $this->controller = $this->controller();
        
        parent::serve();
    }

    protected function controller(): Controller
    {
        $routerMatch = RouterMatchDTO::as($this->request->getAttribute('routerMatch'));
        $id = $routerMatch->params['id'] ?? null;

        $className = strtr($this->classNameControllerPattern(), [
            '{module}' => ucfirst($this->module),
            '{action}' => ucfirst($this->action),
        ]);

        if (!class_exists($className, true)) {
            throw new DynamicClassNotFoundException($className);
        }

        if (is_a($className, __CLASS__, true)) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        foreach ((new \ReflectionClass($className))->getAttributes() as $reflectionAttribute) {
            if (is_a($reflectionAttribute->getName(), RequestMethod::class, true)) {
                $allowRequestMethods = $reflectionAttribute->getArguments();
            }
        }

        if (empty($allowRequestMethods)) {
            throw new DynamicRequestMethodNotDefinedException($className);
        }

        if (!in_array($this->request->getMethod(), $allowRequestMethods, true)) {
            throw new DynamicRequestMethodNotAllowedException($className, $this->request->getMethod());
        }

        $controller = Controller::as($className::new($this->container));
        $controller->request = $this->request->withAttribute('module', $this->module)->withAttribute('action', $this->action)->withAttribute('id', $id);
        $controller->responseCollection = $this->responseCollection;

        $onBeforeServe = new ControllerOnBeforeServeEvent();
        $onBeforeServe->controller = $controller;
        $onBeforeServe->request = $this->request;
        $onBeforeServe->dispatch($this->eventDispatcher());

        return $controller;
    }

    protected function responderOrView(): null|View|Responder
    {
        foreach ($this->classNameResponderViewPatterns() as $pattern) {
            $className = strtr($pattern, [
                '{module}' => ucfirst($this->module),
                '{action}' => ucfirst($this->action),
            ]);

            if (!class_exists($className, true)) {
                continue;
            }

            $unit = Unit::as($className::new($this->container));

            if (!View::is($unit) && !Responder::is($unit)) {
                throw new \Exception('bad type unit');
            }

            return $unit;
        }

        return null;
    }

    #[\Override]
    protected function catch(\Throwable $throwable): void
    {
        if (isset($this->controller)) {
            $this->controller->catch($throwable);
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
