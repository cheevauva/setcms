<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\Application\Contract\ContractArrayable;
use SetCMS\Application\Contract\ContractScopeInterface;
use SetCMS\Application\Contract\ContractHydrateInterface;
use SetCMS\Core\Servant\CorePropertyFetchDataFromRequestServant;
use SetCMS\Core\Servant\CorePropertyHydrateServant;
use SetCMS\Core\Servant\CorePropertySatisfyServant;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\DTO\SetCMSOutputDTO;
use SetCMS\Attribute\ResponderPassProperty;
use UUA\Unit;

abstract class Controller extends Unit implements ContractHydrateInterface, ContractArrayable, ContractScopeInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;

    /**
     * @var array<int, mixed>
     */
    private array $messages = [];

    /**
     * @var array<int, mixed>
     */
    private array $data = [];
    protected ?ServerRequestInterface $request;

    public function getMessages(): array
    {
        return $this->messages;
    }

    protected function isCustomized(): bool
    {
        return true;
    }

    protected function catch(\Throwable $throwable): void
    {
        throw $throwable;
    }

    protected function catchToMessage($field, \Throwable $throwable): void
    {
        $this->messages[] = [
            'field' => $field,
            'message' => $throwable->getMessage(),
        ];
    }

    protected function withMessage(mixed $message): void
    {
        $this->messages[] = $message;
    }

    public function hasMessages(): bool
    {
        return !empty($this->messages);
    }

    protected function validate(): \Iterator
    {
        yield from [];
    }

    public function from(object $object): void
    {
        if ($object instanceof CorePropertyHydrateServant) {
            foreach ($object->messages as $message) {
                $this->withMessage($message);
            }
        }

        if ($object instanceof CorePropertySatisfyServant) {
            foreach ($object->messages as $message) {
                $this->withMessage($message);
            }
        }

        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }

        if ($object instanceof CorePropertyFetchDataFromRequestServant) {
            $this->data = $object->data;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof CorePropertyHydrateServant) {
            $object->object = $this;
            $object->array = $this->data;
        }

        if ($object instanceof CorePropertySatisfyServant) {
            $object->object = $this;
        }

        if ($object instanceof CorePropertyFetchDataFromRequestServant) {
            $object->request = $this->request;
            $object->object = $this;
        }

        if ($object instanceof SetCMSOutputDTO) {
            $object->finalScope($this);
            $object->isSuccess = empty($this->messages);
            
            foreach ($this->messages as $messag) {
                $object->addMessage($messag);
            }
            
            foreach ((new \ReflectionObject($this))->getProperties() as $property) {
                foreach ($property->getAttributes(ResponderPassProperty::class) as $attribute) {
                    assert($attribute instanceof \ReflectionAttribute);
                    $object->set($attribute->getArguments()[0] ?? $property->getName(), $this->{$property->getName()} ?? null);
                }
            }
        }
    }

    /**
     * @return string[]
     */
    protected function units(): array
    {
        return [];
    }

    /**
     * @return array<mixed, mixed>
     */
    public function toArray(): array
    {
        return [];
    }

    #[\Override]
    public function serve(): void
    {
        if ($this->isCustomized()) {
            $this->multiserveUnits([
                CorePropertyFetchDataFromRequestServant::class,
                CorePropertyHydrateServant::class,
                CorePropertySatisfyServant::class,
            ]);
        }

        $this->multiserveUnits($this->units());
    }

    /**
     * @param array<Unit>|array<int, string> $units
     * @return void
     */
    protected function multiserveUnits(array $units): void
    {
        if ($this->hasMessages()) {
            return;
        }

        foreach ($units as $unit) {
            if (is_string($unit)) {
                $unit = $unit::new($this->container);
            }

            if (!($unit instanceof Unit)) {
                throw new \RuntimeException('unit must be extends Unit');
            }

            try {
                $this->to($unit);
                $unit->serve();
                $this->from($unit);
            } catch (\SetCMS\Exception $ex) {
                $this->catch($ex);
            }

            if ($this->hasMessages()) {
                return;
            }
        }
    }
}
