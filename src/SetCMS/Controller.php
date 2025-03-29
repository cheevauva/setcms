<?php

declare(strict_types=1);

namespace SetCMS;

use SplObjectStorage;
use UUA\Unit;
use UUA\ContainerConstructInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View;
use SetCMS\Responder;
use SetCMS\ResponseCollection;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Validation\Validation;

abstract class Controller extends Unit implements ContainerConstructInterface
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \UUA\Traits\EnvTrait;

    public ServerRequestInterface $request;
    public ResponseCollection $responseCollection;
    protected SplObjectStorage $messages;

    protected function init(): void
    {
        $this->messages = new SplObjectStorage();
    }

    protected function catch(\Throwable $throwable): void
    {
        
    }

    protected function mapper(): void
    {
        
    }

    protected function validation(mixed $data): Validation
    {
        if (!is_array($data)) {
            throw new \Exception('Ожидался array, а пришел ' . gettype($data));
        }
        
        return new Validation($data, $this->messages);
    }

    public function from(object $object): void
    {
        if ($object instanceof View && $object->response) {
            $this->responseCollection->attach($object->response, get_class($object));
        }

        if ($object instanceof Responder && $object->response) {
            $this->responseCollection->attach($object->response, get_class($object));
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof Responder) {
            $object->messages = $this->messages;
        }

        if ($object instanceof View) {
            $object->messages = $this->messages;
        }
    }

    /**
     * @return string[]
     */
    protected function domainUnits(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function viewUnits(): array
    {
        return [];
    }

    #[\Override]
    public function serve(): void
    {
        try {
            $onBeforeServe = new ControllerOnBeforeServeEvent();
            $onBeforeServe->controller = $this;
            $onBeforeServe->request = $this->request;
            $onBeforeServe->dispatch($this->eventDispatcher());

            $this->mapper();

            $this->multiserveUnits($this->domainUnits());
        } catch (\Exception $ex) {
            $this->catch($ex);
        } finally {
            $this->multiserveUnits($this->viewUnits(), false);
        }
    }

    /**
     * @param array<Unit>|array<int, string> $units
     * @return void
     */
    protected function multiserveUnits(array $units, bool $breakIfMessages = true): void
    {
        if ($breakIfMessages && $this->messages->count()) {
            return;
        }

        foreach ($units as $unit) {
            if (is_string($unit)) {
                $unit = $unit::new($this->container);
            }

            if (!($unit instanceof Unit)) {
                throw new \RuntimeException('unit must be extends Unit');
            }

            $this->to($unit);
            $unit->serve();
            $this->from($unit);

            if ($breakIfMessages && $this->messages->count()) {
                return;
            }
        }
    }
}
