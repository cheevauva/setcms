<?php

declare(strict_types=1);

namespace SetCMS\Module\Mirror\DAO;

use ReflectionMethod;
use ReflectionAttribute;
use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\Mirror\Entity\MirrorControllerEntity;
use SetCMS\Module\Mirror\Entity\MirrorMethodEntity;
use SetCMS\Attribute\Http\RequestMethod;

class MirrorRetrieveManyMethodsByControllerDAO implements ContractServant
{

    use \SetCMS\Traits\FactoryTrait;

    public MirrorControllerEntity $controller;
    public array $methods;

    #[\Override]
    public function serve(): void
    {
        $this->methods = [];

        $reflectionClass = new \ReflectionClass($this->controller->className);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $reflectionMethod = $this->asReflectionMethod($reflectionMethod);

            if ($reflectionMethod->isStatic()) {
                continue;
            }

            if (!$reflectionMethod->isPublic()) {
                continue;
            }

            $requestMethod = null;

            foreach ($reflectionMethod->getAttributes() as $reflectionAttribute) {
                $reflectionAttribute = $this->asReflectionAttribute($reflectionAttribute);
                
                if (is_a($reflectionAttribute->getName(), RequestMethod::class, true)) {
                    $requestMethod = $reflectionAttribute->getArguments()[0];
                }
            }

            if (!$requestMethod) {
                continue;
            }

            $method = new MirrorMethodEntity;
            $method->name = $reflectionMethod->name;
            $method->requestMethod = $requestMethod;

            $this->methods[] = $method;
        }
    }

    private function asReflectionMethod(ReflectionMethod $reflectionMethod): ReflectionMethod
    {
        return $reflectionMethod;
    }

    private function asReflectionAttribute(ReflectionAttribute $reflectionAttribute): ReflectionAttribute
    {
        return $reflectionAttribute;
    }
}
