<?php

declare(strict_types=1);

namespace SetCMS\Core\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\ContractValidateInterface;
use SetCMS\Attribute;
use SetCMS\Core\VO\CorePropertyMessageVO;
use ReflectionProperty;

class CorePropertySatisfyServant implements Servant
{

    use \SetCMS\QuickTrait;

    public object $object;
    public array $messages = [];

    public function serve(): void
    {
        $object = $this->object;

        $class = new \ReflectionObject($object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            assert($property instanceof ReflectionProperty);

            $rawValue = $property->getValue($object);
            $rawValueType = gettype($rawValue);

            if (!$property->isInitialized($object)) {
                $this->messages[] = new CorePropertyMessageVO('Обязательно для заполнения', $property->getName());
                continue;
            }

            if (empty($rawValue) && !empty($property->getAttributes(Attribute\NotBlank::class))) {
                $this->messages[] = new CorePropertyMessageVO('Обязательно для заполнения', $property->getName());
            }

            if ($rawValue instanceof ContractValidateInterface) {
                $satisfyer = CorePropertySatisfyServant::make($this->factory());
                $satisfyer->object = $rawValue;
                $satisfyer->serve();

                foreach ($satisfyer->messages as $message) {
                    $message = CorePropertyMessageVO::as($message);
                    $this->messages[] = CorePropertyMessageVO::fromArray([
                        $message->message,
                        implode('.', array_filter([
                            $property->getName(),
                            $message->field
                        ])),
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
