<?php

declare(strict_types=1);

namespace SetCMS\Core\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Attribute\Http\Parameter\Query;
use SetCMS\Attribute\Http\Parameter\Headers;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Attribute\Http\Parameter\UploadedFiles;
use SetCMS\Attribute\Http\Parameter\Cookies;
use SetCMS\Attribute\Http\Parameter\Request;

class CorePropertyFetchDataFromRequestServant implements \SetCMS\Contract\Servant
{

    use \SetCMS\FactoryTrait;

    public ServerRequestInterface $request;
    public object $object;
    public array $data = [];

    public function serve(): void
    {
        $this->data = [];

        $reflectionClass = new \ReflectionClass($this->object);
        $reflectionProperties = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($reflectionProperties as $reflectionProperty) {
            foreach ($reflectionProperty->getAttributes() as $reflectionAttribute) {
                $this->handleProperty($reflectionProperty, $reflectionAttribute);
            }
        }
    }

    protected function handleProperty(\ReflectionProperty $reflectionProperty, \ReflectionAttribute $reflectionAttribute): void
    {
        $propertyName = $reflectionProperty->getName();
        $attrClass = $reflectionAttribute->getName();
        $argument0 = $reflectionAttribute->getArguments()[0] ?? null;

        if (!empty($argument0)) {
            if (is_a($attrClass, Body::class, true)) {
                $this->data[$propertyName] = $this->request->getParsedBody()[$argument0] ?? null;
            }

            if (is_a($attrClass, Query::class, true)) {
                $this->data[$propertyName] = $this->request->getQueryParams()[$argument0] ?? null;
            }

            if (is_a($attrClass, Cookies::class, true)) {
                $this->data[$propertyName] = $this->request->getCookieParams()[$argument0] ?? null;
            }

            if (is_a($attrClass, Headers::class, true)) {
                $this->data[$propertyName] = $this->request->getHeaderLine($argument0);
            }

            if (is_a($attrClass, UploadedFiles::class, true)) {
                $this->data[$propertyName] = $this->request->getUploadedFiles()[$argument0] ?? null;
            }

            if (is_a($attrClass, Attributes::class, true)) {
                $this->data[$propertyName] = $this->request->getAttribute($argument0);
            }
        }

        if (is_a($attrClass, Request::class, true)) {
            $this->data[$propertyName] = $this->request;
        }
    }

}
