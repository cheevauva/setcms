<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Controller;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Application\Router\Exception\RouterNotAllowRequestMethodException;
use SetCMS\Application\Router\Exception\RouterMethodRequestNotDefinedException;
use SetCMS\Attribute\Http\Parameter\Attributes;

abstract class DynamicBaseController extends Controller
{

    use \UUA\Traits\EventDispatcherTrait;
    use \UUA\Traits\EnvTrait;

    #[Attributes('module')]
    public string $module;

    #[Attributes('action')]
    public string $action;
    protected Controller $controller;

    abstract protected function classNamePattern();

    #[\Override]
    protected function units(): array
    {
        return [
            $this->controller,
        ];
    }

    #[\Override]
    public function serve(): void
    {
        $this->controller = $this->controller();

        parent::serve();
    }

    #[\Override]
    protected function isCustomized(): bool
    {
        return false;
    }

    protected function controller(): Controller
    {
        $className = strtr($this->classNamePattern(), [
            '{module}' => ucfirst($this->request->getAttribute('module')),
            '{action}' => ucfirst($this->request->getAttribute('action')),
        ]);

        if (is_a($className, __CLASS__, true)) {
            throw new \RuntimeException('Oh my sweet summer child - you know noting');
        }

        foreach ((new \ReflectionClass($className))->getAttributes() as $reflectionAttribute) {
            if (is_a($reflectionAttribute->getName(), RequestMethod::class, true)) {
                $allowRequestMethods = $reflectionAttribute->getArguments();
            }
        }

        if (empty($allowRequestMethods)) {
            throw new RouterMethodRequestNotDefinedException(sprintf('В обработчике %s не указан ожидаемый тип метода запроса', $className));
        }

        if (!in_array($this->request->getMethod(), $allowRequestMethods, true)) {
            throw new RouterNotAllowRequestMethodException;
        }

        $controller = Controller::as($className::new($this->container));
        $controller->from($this->request);

        $event = new ScopeProtectionHook();
        $event->scope = $controller;
        $event->user = $this->request->getAttribute('currentUser');
        $event->dispatch($this->eventDispatcher());

        return $controller;
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
