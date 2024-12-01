<?php

declare(strict_types=1);

namespace SetCMS\Core\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Application\Contract\ContractValidateInterface;
use SetCMS\Attribute;
use SetCMS\Core\VO\CorePropertyMessageVO;
use ReflectionProperty;

class CorePropertySatisfyServant implements ContractServant
{

    use \SetCMS\Traits\QuickTrait;

    public object $object;
    public array $messages = [];

    public function serve(): void
    {
        $object = $this->object;

        $class = new \ReflectionObject($object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof ReflectionProperty);

            $rawValue = $property->isInitialized($object) ? $property->getValue($object) : null;
            $rawValueType = gettype($rawValue);

            if (!$property->isInitialized($object)) {
                $this->messages[] = new CorePropertyMessageVO($property->getName(), 'Обязательно для заполнения');
                continue;
            }

            if (empty($rawValue) && !empty($property->getAttributes(Attribute\NotBlank::class))) {
                $this->messages[] = new CorePropertyMessageVO($property->getName(), 'Обязательно для заполнения');
            }

            if ($rawValue instanceof ContractValidateInterface) {
                $satisfyer = CorePropertySatisfyServant::make($this->factory());
                $satisfyer->object = $rawValue;
                $satisfyer->serve();

                foreach ($satisfyer->messages as $message) {
                    $message = CorePropertyMessageVO::as($message);
                    $this->messages[] = CorePropertyMessageVO::fromArray([
                        implode('.', array_filter([
                            $property->getName(),
                            $message->field
                        ])),
                        $message->message,
                    ]);
                }
            }
        }

        if ($object instanceof ContractValidateInterface) {
            foreach ($object->validate() as $message) {
                $this->messages[] = CorePropertyMessageVO::fromArray($message);
            }
        }
    }

}
